<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Certificates\CertificateData;
use App\Models\Code\Loans;
use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LoansController extends Controller
{
    // Display a listing of the loans
    public function index(Request $request)
    {
        $subAccountKeyId = $request->input('sub_account_key_id');
        $reportKey = $request->input('report_key');
        $date = $request->input('date');
        $perPage = $request->input('per_page', 25);

        $query = Loans::query();
        if ($subAccountKeyId) {
            $query->whereHas('subAccountKey', function ($q) use ($subAccountKeyId) {
                $q->where('sub_account_key_column_in_related_table', 'like', "%{$subAccountKeyId}%");
            });
        }
        if ($reportKey) {
            $query->whereHas('reportKey', function ($q) use ($reportKey) {
                $q->where('report_key_column_in_related_table', 'like', "%{$reportKey}%");
            });
        }
        $loans = $query->paginate($perPage);

        return view('layouts.admin.forms.loans.loans-index', compact('loans'));
    }

    public function create()
    {
        $subAccountKeys = SubAccountKey::all();
        $reports = Report::all();

        return view('layouts.admin.forms.loans.loans-create', compact('subAccountKeys', 'reports'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'internal_increase' => 'nullable|numeric|min:0',
            'unexpected_increase' => 'nullable|numeric|min:0',
            'additional_increase' => 'nullable|numeric|min:0',
            'decrease' => 'nullable|numeric|min:0',
            'editorial' => 'nullable|numeric|min:0',
            'fin_law' => 'nullable|numeric|min:0', // Ensure fin_law is validated
        ]);

        // Set default values for nullable fields if not provided
        $validatedData['internal_increase'] = $validatedData['internal_increase'] ?? 0;
        $validatedData['unexpected_increase'] = $validatedData['unexpected_increase'] ?? 0;
        $validatedData['additional_increase'] = $validatedData['additional_increase'] ?? 0;
        $validatedData['decrease'] = $validatedData['decrease'] ?? 0;
        $validatedData['editorial'] = $validatedData['editorial'] ?? 0;

        // Set a default value for fin_law if not provided
        $validatedData['fin_law'] = $validatedData['fin_law'] ?? 0;

        // Calculate total_increase
        $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];

        // Check for existing records with the same sub_account_key and report_key in Report
        $existingReport = Report::where('id', $validatedData['report_key'])
            ->first();

        if (!$existingReport) {
            return redirect()->back()->withErrors([
                'report_key' => 'The combination of Sub-Account Key ID and Report Key does not exist in reports.'
            ])->withInput();
        }


        // Retrieve the current loan value from the existing report
        $current_loan = $existingReport->current_loan;

        // Calculate new_credit_status
        $new_credit_status = $current_loan + $total_increase - $validatedData['decrease'] - $validatedData['editorial'];

        // Fetch the sum of certificate values related to the report
        $currentApplyTotal = CertificateData::where('report_key', $validatedData['report_key'])->sum('value_certificate');

        // Ensure early_balance is set to 0 if no previous records exist
        $early_balance = $currentApplyTotal > 0 ? $currentApplyTotal : 0;

        // Calculate deadline_balance and credit
        $deadline_balance = $currentApplyTotal;
        $credit = $new_credit_status - $deadline_balance;

        // Calculate law_average and law_correction
        $law_average = $validatedData['fin_law'] ? max(-100, min(100, ($deadline_balance / $validatedData['fin_law']) * 100)) : 0;
        $law_correction = $early_balance ? max(-100, min(100, ($deadline_balance / $new_credit_status) * 100)) : 0;

        // Store the loan data, including calculated values
        Loans::create([
            // 'sub_account_key' => $validatedData['sub_account_key'],
            'report_key' => $validatedData['report_key'],
            'internal_increase' => $validatedData['internal_increase'],
            'unexpected_increase' => $validatedData['unexpected_increase'],
            'additional_increase' => $validatedData['additional_increase'],
            'decrease' => $validatedData['decrease'],
            'editorial' => $validatedData['editorial'],
            'total_increase' => $total_increase,
        ]);

        // Update the existing report with new values
        $existingReport->update([
            'new_credit_status' => $new_credit_status,
            'apply' => $currentApplyTotal,
            'deadline_balance' => $deadline_balance,
            'credit' => $credit,
            'law_average' => $law_average,
            'law_correction' => $law_correction,
            'current_loan' => $current_loan,
        ]);

        return redirect()->route('loans.index')->with('success', 'Loan created successfully.');
    }

    // Show the form for editing an existing loan
    public function edit($id)
    {
        // Fetch the loan by ID
        $loan = Loans::findOrFail($id);

        // Fetch all reports related to loans
        $reports = Report::all(); // Adjust to fetch all reports

        // Fetch all available sub-account keys for the dropdown
        $subAccountKeys = SubAccountKey::all();

        // Return the view with the data
        return view('layouts.admin.forms.loans.loans-edit', compact('loan', 'reports', 'subAccountKeys'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'internal_increase' => 'nullable|numeric|min:0',
            'unexpected_increase' => 'nullable|numeric|min:0',
            'additional_increase' => 'nullable|numeric|min:0',
            'decrease' => 'nullable|numeric|min:0',
            'editorial' => 'nullable|numeric|min:0',
        ]);

        // Set default values for nullable fields if not provided
        $validatedData['internal_increase'] = $validatedData['internal_increase'] ?? 0;
        $validatedData['unexpected_increase'] = $validatedData['unexpected_increase'] ?? 0;
        $validatedData['additional_increase'] = $validatedData['additional_increase'] ?? 0;
        $validatedData['decrease'] = $validatedData['decrease'] ?? 0;
        $validatedData['editorial'] = $validatedData['editorial'] ?? 0;

        // Find the existing loan by ID
        $loan = Loans::findOrFail($id);

        // Check for existing records with the same report_key in Report
        $existingReport = Report::where('id', $validatedData['report_key'])->first();

        if (!$existingReport) {
            return redirect()->back()->withErrors([
                'report_key' => 'The Report Key does not exist.'
            ])->withInput();
        }

        // Retrieve the current loan value and the fin_law value from the existing report
        $current_loan = $existingReport->current_loan;
        $fin_law = $existingReport->fin_law; // Retrieve fin_law from the report

        // Calculate total_increase
        $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];

        // Calculate new_credit_status
        $new_credit_status = $current_loan + $total_increase - $validatedData['decrease'] - $validatedData['editorial'];

        // Fetch the sum of certificate values related to the report
        $currentApplyTotal = CertificateData::where('report_key', $validatedData['report_key'])->sum('value_certificate');

        // Ensure early_balance is set to 0 if no previous records exist
        $early_balance = $currentApplyTotal > 0 ? $currentApplyTotal : 0;

        // Calculate deadline_balance and credit
        $deadline_balance = $currentApplyTotal;
        $credit = $new_credit_status - $deadline_balance;

        // Calculate law_average and law_correction using the retrieved fin_law value
        $law_average = $fin_law ? max(-100, min(100, ($deadline_balance / $fin_law) * 100)) : 0;
        $law_correction = $new_credit_status ? max(-100, min(100, ($deadline_balance / $new_credit_status) * 100)) : 0;

        // Update the loan data, including calculated values
        $loan->update([
            'report_key' => $validatedData['report_key'],
            'internal_increase' => $validatedData['internal_increase'],
            'unexpected_increase' => $validatedData['unexpected_increase'],
            'additional_increase' => $validatedData['additional_increase'],
            'decrease' => $validatedData['decrease'],
            'editorial' => $validatedData['editorial'],
            'total_increase' => $total_increase,
        ]);

        // Update the existing report with new values
        $existingReport->update([
            'new_credit_status' => $new_credit_status,
            'apply' => $currentApplyTotal,
            'deadline_balance' => $deadline_balance,
            'credit' => $credit,
            'law_average' => $law_average,
            'law_correction' => $law_correction,
            'current_loan' => $current_loan,
        ]);

        return redirect()->route('loans.index')->with('success', 'Loan updated successfully.');
    }

    public function destroy($id)
    {
        // Find the loan by ID
        $loan = Loans::findOrFail($id);

        // Get the report associated with the loan
        $report = Report::find($loan->report_key);

        if ($report) {
            // Deduct the loan's values from the current report
            $total_increase = $loan->internal_increase + $loan->unexpected_increase + $loan->additional_increase;

            // Recalculate new_credit_status
            $new_credit_status = $report->new_credit_status - $total_increase + $loan->decrease + $loan->editorial;

            // Recalculate the apply total from related CertificateData
            $currentApplyTotal = CertificateData::where('report_key', $report->id)->sum('value_certificate');

            // Ensure early_balance is set to 0 if no previous records exist
            $early_balance = $currentApplyTotal > 0 ? $currentApplyTotal : 0;

            // Recalculate deadline_balance and credit
            $deadline_balance = $currentApplyTotal;
            $credit = $new_credit_status - $deadline_balance;

            // Recalculate law_average and law_correction
            $law_average = $report->fin_law ? max(-100, min(100, ($deadline_balance / $report->fin_law) * 100)) : 0;
            $law_correction = $new_credit_status ? max(-100, min(100, ($deadline_balance / $new_credit_status) * 100)) : 0;

            // Update the report with the recalculated values
            $report->update([
                'new_credit_status' => $new_credit_status,
                'apply' => $currentApplyTotal,
                'deadline_balance' => $deadline_balance,
                'credit' => $credit,
                'law_average' => $law_average,
                'law_correction' => $law_correction,
            ]);
        }

        // Now delete the loan record
        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Loan deleted and report updated successfully.');
    }

    // Show the form import input data into 
    public function showImportForm()
    {
        return view('layouts.admin.forms.loans.loans-import');
    }

    // Show a newly the import to store database
    public function import(Request $request)
    {
        // Validate that a file is uploaded
        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx'
        ]);

        // Load the file
        $file = $request->file('excel_file');

        try {
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();

            // Start reading the rows and columns
            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Loop through all cells, even empty ones

                $rowData = [];
                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }

                $subAccountKeyValue = $rowData[0]; // Extract sub_account_key value

                // Find the sub_account_key in the database
                $subAccountKey = SubAccountKey::where('sub_account_key', $subAccountKeyValue)->first();

                $loanData = [
                    // 'sub_account_key' => $rowData[0],
                    'sub_account_key' => $subAccountKey ? $subAccountKey->id : null,
                    'report_key' => $rowData[1],
                    'name_report_key' => $rowData[2],
                    'fin_law' => $rowData[3],
                    'current_loan' => $rowData[4],
                ];

                // Store the data in the Loans table
                Loans::create($loanData);
            }

            return redirect()->route('loans.index')->with('success', 'Data imported successfully.');
        } catch (Exception $e) {
            Log::error('Error loading file: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'There was an error importing the file.']);
        }
    }

    // Private method to calculate early balance
    private function calculateEarlyBalance($report)
    {
        // Fetch all certificate data for the given report_key, ordered by creation date
        $certificateData = CertificateData::where('report_key', $report->report_key)
            ->orderBy('created_at', 'asc') // Order by creation date to exclude the last record
            ->get();

        // If there is only one record or none, early_balance should be 0
        if ($certificateData->count() === 1) {
            return 0;
        }

        // Exclude the last record and sum all values
        $totalEarlyBalance = $certificateData->slice(0, -1) // Exclude the last record
            ->filter(function ($item) {
                return !is_null($item->value_certificate) && $item->value_certificate !== '';
            })
            ->sum('value_certificate');

        // Return the calculated balance, or 0 if no valid certificates
        return $totalEarlyBalance;
    }
}
