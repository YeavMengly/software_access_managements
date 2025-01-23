<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Certificates\CertificateData;
use App\Models\Code\Loans;
use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use Illuminate\Support\Facades\Log;

class LoansController extends Controller
{
    public function index(Request $request)
    {
        $subAccountKeyId = $request->input('sub_account_key_id');
        $reportKey = $request->input('report_key');
        $perPage = $request->input('per_page', 25);

        $query = Loans::query();

        // Filter by Sub-Account Key
        if ($subAccountKeyId) {
            $query->whereHas('subAccountKey', function ($q) use ($subAccountKeyId) {
                $q->where('sub_account_key_column_in_related_table', 'like', "%{$subAccountKeyId}%");
            });
        }

        // Filter by Report Key and Year Status
        if ($reportKey) {
            $query->whereHas('report', function ($q) use ($reportKey) {
                $q->where('report_key_column_in_related_table', 'like', "%{$reportKey}%")
                    ->whereHas('year', function ($q) {
                        $q->where('status', 'active');
                    });
            });
        } else {
            $query->whereHas('report.year', function ($q) {
                $q->where('status', 'active');
            });
        }

        // Paginate Results
        $loans = $query->paginate($perPage);

        return view('layouts.admin.forms.loans.loans-index', compact('loans'));
    }

    public function create()
    {
        $subAccountKeys = SubAccountKey::all();

        $reports = Report::whereHas('year', function ($query) {
            $query->where('status', 'active')
                ->where('date_year', '>=', Carbon::now()->startOfYear()); // Compare _year in the related model
        })->get();

        return view('layouts.admin.forms.loans.loans-create', compact('subAccountKeys', 'reports'));
    }
   
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'internal_increase' => 'nullable|numeric|min:0',
            'unexpected_increase' => 'nullable|numeric|min:0',
            'additional_increase' => 'nullable|numeric|min:0',
            'decrease' => 'nullable|numeric|min:0',
            'editorial' => 'nullable|numeric|min:0',
        ]);
    
        $validatedData['internal_increase'] = $validatedData['internal_increase'] ?? 0;
        $validatedData['unexpected_increase'] = $validatedData['unexpected_increase'] ?? 0;
        $validatedData['additional_increase'] = $validatedData['additional_increase'] ?? 0;
        $validatedData['decrease'] = $validatedData['decrease'] ?? 0;
        $validatedData['editorial'] = $validatedData['editorial'] ?? 0;
    
        $existingReport = Report::where('id', $validatedData['report_key'])->first();
    
        if (!$existingReport) {
            return redirect()->back()->withErrors([
                'report_key' => 'The selected report does not exist.'
            ])->withInput();
        }
    
        $current_loan = $existingReport->current_loan;
        $fin_law = $existingReport->fin_law;
        $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];
        $new_credit_status = $current_loan + $total_increase - $validatedData['decrease'] - $validatedData['editorial'];
        $currentApplyTotal = CertificateData::where('report_key', $validatedData['report_key'])->sum('value_certificate');
        $deadline_balance = $currentApplyTotal;
        $credit = $new_credit_status - $deadline_balance;
        $law_average = $fin_law ? max(-100, min(100, ($deadline_balance / $fin_law) * 100)) : 0;
        $law_correction = $new_credit_status ? max(-100, min(100, ($deadline_balance / $new_credit_status) * 100)) : 0;
    
        Loans::create([
            'sub_account_key' => $existingReport->sub_account_key ?? null,
            'report_key' => $validatedData['report_key'],
            'internal_increase' => $validatedData['internal_increase'],
            'unexpected_increase' => $validatedData['unexpected_increase'],
            'additional_increase' => $validatedData['additional_increase'],
            'decrease' => $validatedData['decrease'],
            'editorial' => $validatedData['editorial'],
            'total_increase' => $total_increase,
        ]);
    
        $existingReport->update([
            'new_credit_status' => $new_credit_status,
            'apply' => $currentApplyTotal,
            'deadline_balance' => $deadline_balance,
            'credit' => $credit,
            'law_average' => $law_average,
            'law_correction' => $law_correction,
            'current_loan' => $current_loan,
        ]);
    
        return redirect()->route('loans.index')->with('success', 'Loan transaction added successfully!');
    }

   
    public function edit($id)
    {
        $loan = Loans::findOrFail($id);
        $reports = Report::all();
        $subAccountKeys = SubAccountKey::all();

        return view('layouts.admin.forms.loans.loans-edit', compact('loan', 'reports', 'subAccountKeys'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'internal_increase' => 'nullable|numeric|min:0',
            'unexpected_increase' => 'nullable|numeric|min:0',
            'additional_increase' => 'nullable|numeric|min:0',
            'decrease' => 'nullable|numeric|min:0',
            'editorial' => 'nullable|numeric|min:0',
        ]);

        $validatedData['internal_increase'] = $validatedData['internal_increase'] ?? 0;
        $validatedData['unexpected_increase'] = $validatedData['unexpected_increase'] ?? 0;
        $validatedData['additional_increase'] = $validatedData['additional_increase'] ?? 0;
        $validatedData['decrease'] = $validatedData['decrease'] ?? 0;
        $validatedData['editorial'] = $validatedData['editorial'] ?? 0;

        $loan = Loans::findOrFail($id);

        $existingReport = Report::where('id', $validatedData['report_key'])->first();

        if (!$existingReport) {
            return redirect()->back()->withErrors([
                'report_key' => 'The Report Key does not exist.'
            ])->withInput();
        }

        $current_loan = $existingReport->current_loan;
        $fin_law = $existingReport->fin_law;
        $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];
        $new_credit_status = $current_loan + $total_increase - $validatedData['decrease'] - $validatedData['editorial'];
        $currentApplyTotal = CertificateData::where('report_key', $validatedData['report_key'])->sum('value_certificate');
        $deadline_balance = $currentApplyTotal;
        $credit = $new_credit_status - $deadline_balance;
        $law_average = $fin_law ? max(-100, min(100, ($deadline_balance / $fin_law) * 100)) : 0;
        $law_correction = $new_credit_status ? max(-100, min(100, ($deadline_balance / $new_credit_status) * 100)) : 0;

        $loan->update([
            'report_key' => $validatedData['report_key'],
            'internal_increase' => $validatedData['internal_increase'],
            'unexpected_increase' => $validatedData['unexpected_increase'],
            'additional_increase' => $validatedData['additional_increase'],
            'decrease' => $validatedData['decrease'],
            'editorial' => $validatedData['editorial'],
            'total_increase' => $total_increase,
        ]);
        $existingReport->update([
            'new_credit_status' => $new_credit_status,
            'apply' => $currentApplyTotal,
            'deadline_balance' => $deadline_balance,
            'credit' => $credit,
            'law_average' => $law_average,
            'law_correction' => $law_correction,
            'current_loan' => $current_loan,
        ]);

        return redirect()->route('loans.index')->with('success', 'ចលនាឥណទានបានកែដោយជោគជ័យ។');
    }

    public function destroy($id)
    {
        $loan = Loans::findOrFail($id);
        $report = Report::find($loan->report_key);

        if ($report) {

            $total_increase = $loan->internal_increase + $loan->unexpected_increase + $loan->additional_increase;
            $new_credit_status = $report->new_credit_status - $total_increase + $loan->decrease + $loan->editorial;
            $currentApplyTotal = CertificateData::where('report_key', $report->id)->sum('value_certificate');

            $deadline_balance = $currentApplyTotal;
            $credit = $new_credit_status - $deadline_balance;
            $law_average = $report->fin_law ? max(-100, min(100, ($deadline_balance / $report->fin_law) * 100)) : 0;
            $law_correction = $new_credit_status ? max(-100, min(100, ($deadline_balance / $new_credit_status) * 100)) : 0;
            $report->update([
                'new_credit_status' => $new_credit_status,
                'apply' => $currentApplyTotal,
                'deadline_balance' => $deadline_balance,
                'credit' => $credit,
                'law_average' => $law_average,
                'law_correction' => $law_correction,
            ]);
        }
        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'ចលនាឥណទានបានលុបដោយជោគជ័យ។');
    }

    public function showImportForm()
    {
        return view('layouts.admin.forms.loans.loans-import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('excel_file');

        try {
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();

            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $rowData = [];
                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $subAccountKeyValue = $rowData[0];

                $subAccountKey = SubAccountKey::where('sub_account_key', $subAccountKeyValue)->first();

                $loanData = [
                    'sub_account_key' => $subAccountKey ? $subAccountKey->id : null,
                    'report_key' => $rowData[1],
                    'name_report_key' => $rowData[2],
                    'fin_law' => $rowData[3],
                    'current_loan' => $rowData[4],
                ];
                Loans::create($loanData);
            }

            return redirect()->route('loans.index')->with('success', 'Data imported successfully.');
        } catch (Exception $e) {
            Log::error('Error loading file: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'There was an error importing the file.']);
        }
    }
}
