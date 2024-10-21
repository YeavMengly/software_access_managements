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

        // Filter by SubAccountKey if provided
        if ($subAccountKeyId) {
            $query->whereHas('subAccountKey', function ($q) use ($subAccountKeyId) {
                $q->where('sub_account_key', 'like', "%{$subAccountKeyId}%");
            });
        }

        // Filter by ReportKey if provided, using the relationship
        if ($reportKey) {
            $query->whereHas('reportKey', function ($q) use ($reportKey) {
                $q->where('report_key', 'like', "%{$reportKey}%");
            });
        }

        // Optional: Add date filtering logic here if needed

        // Paginate the results
        $loans = $query->paginate($perPage);

        // Return the view with loans data
        return view('layouts.admin.forms.loans.loans-index', compact('loans'));
    }



    // Show the form for creating a new loan
    public function create()
    {
        // Fetch all available sub-account keys for the dropdown
        $subAccountKeys = SubAccountKey::all();
        $reports = Report::all();

        return view('layouts.admin.forms.loans.loans-create', compact('subAccountKeys', 'reports'));
    }

    // Store a newly created loan in the database
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'sub_account_key' => 'required|exists:sub_account_keys,id',
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
    
        // Calculate total_increase
        $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];

        // Merge total_increase into the validated data
        $dataToStore = array_merge($validatedData, [
            'total_increase' => $total_increase,
            // 'new_credit_status' => $new_credit_status,
        ]);
    
        // Create a new loan record in the database
        Loans::create($dataToStore);
    
        return redirect()->route('loans.index')->with('success', 'Loan created successfully.');
    }
    


    // Show the form for editing an existing loan
    public function edit($id)
    {
        // Fetch the loan by ID
        $loan = Loans::findOrFail($id);

        // Fetch all available sub-account keys for the dropdown
        $subAccountKeys = SubAccountKey::all();

        return view('layouts.admin.forms.loans.loans-edit', compact('loan', 'subAccountKeys'));
    }

    // Update the specified loan in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'sub_account_key' => 'required|exists:sub_account_keys,id',
            'report_key' => 'required|string|max:255',
            'internal_increase' => 'nullable|numeric|min:0',
            'unexpected_increase' => 'nullable|numeric|min:0',
            'additional_increase' => 'nullable|numeric|min:0',
            'decrease' => 'nullable|numeric|min:0',
            'editorial' => 'nullable|numeric|min:0',

        ]);

        // Find the loan by ID and update it with the new data
        $loan = Loans::findOrFail($id);
        $loan->update($validatedData);

        return redirect()->route('loans.index')->with('success', 'Loan updated successfully.');
    }

    // Delete a loan from the database
    public function destroy($id)
    {
        // Find the loan by ID and delete it
        $loan = Loans::findOrFail($id);
        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Loan deleted successfully.');
    }

    public function showImportForm()
    {
        return view('layouts.admin.forms.loans.loans-import');
    }
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