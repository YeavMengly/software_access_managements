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

        if ($subAccountKeyId) {
            $query->whereHas('subAccountKey', function ($q) use ($subAccountKeyId) {
                $q->where('sub_account_key_column_in_related_table', 'like', "%{$subAccountKeyId}%");
            });
        }

        if ($reportKey) {
            $query->whereHas('reportKey.year', function ($q) {
                $q->where('status', 'active');
            })->whereHas('reportKey', function ($q) use ($reportKey) {
                $q->where('report_key_column_in_related_table', 'like', "%{$reportKey}%");
            });
        } else {
            $query->whereHas('reportKey.year', function ($q) {
                $q->where('status', 'active');
            });
        }

        $loans = $query->paginate($perPage);

        return view('layouts.admin.forms.loans.loans-index', compact('loans'));
    }
    // public function create()
    // {
    //     $subAccountKeys = SubAccountKey::all();
    //     $reports = Report::all();

    //     return view('layouts.admin.forms.loans.loans-create', compact('subAccountKeys', 'reports'));
    // }

    public function create()
    {
        $subAccountKeys = SubAccountKey::all();
        $reports = Report::with('year')
            ->whereHas('year', function ($query) {
                $query->where('status', 'active');
            })
            ->get();

        return view('layouts.admin.forms.loans.loans-create', compact('subAccountKeys', 'reports'));
    }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'report_key' => 'required|exists:reports,id',
    //         'internal_increase' => 'nullable|numeric|min:0',
    //         'unexpected_increase' => 'nullable|numeric|min:0',
    //         'additional_increase' => 'nullable|numeric|min:0',
    //         'decrease' => 'nullable|numeric|min:0',
    //         'editorial' => 'nullable|numeric|min:0',
    //     ]);

    //     $validatedData['internal_increase'] = $validatedData['internal_increase'] ?? 0;
    //     $validatedData['unexpected_increase'] = $validatedData['unexpected_increase'] ?? 0;
    //     $validatedData['additional_increase'] = $validatedData['additional_increase'] ?? 0;
    //     $validatedData['decrease'] = $validatedData['decrease'] ?? 0;
    //     $validatedData['editorial'] = $validatedData['editorial'] ?? 0;

    //     $validatedData['fin_law'] = $validatedData['fin_law'] ?? 0;
    //     // Retrieve the associated Report
    //     $report = Report::with('year')->find($validatedData['report_key']);
    //     if (!$report) {
    //         return redirect()->back()->withErrors([
    //             'report_key' => 'The selected report does not exist.',
    //         ])->withInput();
    //     }

    //     // Retrieve the associated Year
    //     $year = $report->year;
    //     if (!$year) {
    //         return redirect()->back()->withErrors([
    //             'year_id' => 'The associated year for the report is missing.',
    //         ])->withInput();
    //     }

    //     // Check if the current year matches the year in the Report and Year models
    //     $currentYear = Carbon::now()->year;
    //     if ($year->date_year->year !== $currentYear || $report->year_id !== $year->id) {
    //         return redirect()->back()->withErrors([
    //             'report_key' => 'The report year does not match the current year or is invalid.',
    //         ])->withInput();
    //     }

    //     $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];
    //     $existingReport = Report::where('id', $validatedData['report_key'])
    //         ->first();
    //     if (!$existingReport) {
    //         return redirect()->back()->withErrors([
    //             'report_key' => 'The combination of Sub-Account Key ID and Report Key does not exist in reports.'
    //         ])->withInput();
    //     }

    //     $subAccountKey = $existingReport->subAccountKey->sub_account_key;

    //     $current_loan = $existingReport->current_loan;
    //     $new_credit_status = $current_loan + $total_increase - $validatedData['decrease'] - $validatedData['editorial'];
    //     $currentApplyTotal = CertificateData::where('report_key', $validatedData['report_key'])->sum('value_certificate');
    //     $early_balance = $currentApplyTotal > 0 ? $currentApplyTotal : 0;
    //     $deadline_balance = $currentApplyTotal;
    //     $credit = $new_credit_status - $deadline_balance;
    //     $law_average = $validatedData['fin_law'] ? max(-100, min(100, ($deadline_balance / $validatedData['fin_law']) * 100)) : 0;
    //     $law_correction = $early_balance ? max(-100, min(100, ($deadline_balance / $new_credit_status) * 100)) : 0;

    //     Loans::create([
    //         'sub_account_key' => $subAccountKey,
    //         'report_key' => $validatedData['report_key'],
    //         'internal_increase' => $validatedData['internal_increase'],
    //         'unexpected_increase' => $validatedData['unexpected_increase'],
    //         'additional_increase' => $validatedData['additional_increase'],
    //         'decrease' => $validatedData['decrease'],
    //         'editorial' => $validatedData['editorial'],
    //         'total_increase' => $total_increase,
    //     ]);
    //     $existingReport->update([
    //         'new_credit_status' => $new_credit_status,
    //         'apply' => $currentApplyTotal,
    //         'deadline_balance' => $deadline_balance,
    //         'credit' => $credit,
    //         'law_average' => $law_average,
    //         'law_correction' => $law_correction,
    //         'current_loan' => $current_loan,
    //     ]);

    //     return redirect()->route('loans.index')->with('success', 'ចលនាឥណទានបានបញ្ជូលដោយជោគជ័យ។');
    // }
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

        // Retrieve the associated Report with its active Year
        $report = Report::with('year')
            ->whereHas('year', function ($query) {
                $query->where('status', 'active');
            })
            ->find($validatedData['report_key']);

        // If the report doesn't exist or is tied to an inactive year, redirect back with an error
        if (!$report) {
            return redirect()->back()->withErrors([
                'report_key' => 'The selected report is either inactive or does not exist.',
            ])->withInput();
        }

        // Proceed with loan record creation
        $validatedData['internal_increase'] = $validatedData['internal_increase'] ?? 0;
        $validatedData['unexpected_increase'] = $validatedData['unexpected_increase'] ?? 0;
        $validatedData['additional_increase'] = $validatedData['additional_increase'] ?? 0;
        $validatedData['decrease'] = $validatedData['decrease'] ?? 0;
        $validatedData['editorial'] = $validatedData['editorial'] ?? 0;

        $total_increase = $validatedData['internal_increase'] +
            $validatedData['unexpected_increase'] +
            $validatedData['additional_increase'];

        $subAccountKey = $report->subAccountKey->sub_account_key;
        $current_loan = $report->current_loan;

        // Calculate new credit status
        $new_credit_status = $current_loan + $total_increase -
            $validatedData['decrease'] -
            $validatedData['editorial'];

        Loans::create([
            'sub_account_key' => $subAccountKey,
            'report_key' => $validatedData['report_key'],
            'internal_increase' => $validatedData['internal_increase'],
            'unexpected_increase' => $validatedData['unexpected_increase'],
            'additional_increase' => $validatedData['additional_increase'],
            'decrease' => $validatedData['decrease'],
            'editorial' => $validatedData['editorial'],
            'total_increase' => $total_increase,
        ]);

        $report->update([
            'new_credit_status' => $new_credit_status,
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
