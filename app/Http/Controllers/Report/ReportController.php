<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Imports\ReportsImport;
use App\Models\Certificates\CertificateData;
use App\Models\Code\Loans;
use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the filter inputs with sensible defaults
        $codeId = $request->input('code_id');
        $accountKeyId = $request->input('account_key_id');
        $subAccountKeyId = $request->input('sub_account_key_id');
        $reportKey = $request->input('report_key');
        $date = $request->input('date'); // Date filter input
        $perPage = $request->input('per_page', 25); // Default to 25 if not specified

        // Start building the query
        $query = Report::query();

        // Apply filters conditionally
        if ($codeId) {
            $query->whereHas('subAccountKey.accountKey.key', function ($q) use ($codeId) {
                $q->where('code', 'like', "%{$codeId}%");
            });
        }

        if ($accountKeyId) {
            $query->whereHas('subAccountKey.accountKey', function ($q) use ($accountKeyId) {
                $q->where('account_key', 'like', "%{$accountKeyId}%");
            });
        }

        if ($subAccountKeyId) {
            $query->whereHas('subAccountKey', function ($q) use ($subAccountKeyId) {
                $q->where('sub_account_key', 'like', "%{$subAccountKeyId}%");
            });
        }

        if ($reportKey) {
            $query->where('report_key', 'like', "%{$reportKey}%");
        }

        // Apply date filter (single date or range)
        if ($date) {
            try {
                if (strpos($date, ' - ') !== false) {
                    // Date range
                    [$startDate, $endDate] = explode(' - ', $date);
                    $query->whereBetween('created_at', [
                        Carbon::createFromFormat('Y-m-d', trim($startDate))->startOfDay(),
                        Carbon::createFromFormat('Y-m-d', trim($endDate))->endOfDay()
                    ]);
                } else {
                    // Single date
                    $query->whereDate('created_at', Carbon::createFromFormat('Y-m-d', $date)->toDateString());
                }
            } catch (\Exception $e) {
                // Handle invalid date format
                Log::error('Invalid date format: ' . $e->getMessage());
                return redirect()->back()->withErrors(['date' => 'Invalid date format. Please use YYYY-MM-DD or a date range (YYYY-MM-DD - YYYY-MM-DD).']);
            }
        }

        // Paginate the results
        $reports = $query->paginate($perPage);

        // Return the view with the filtered reports
        return view('layouts.admin.forms.code.report-index', compact('reports'));
    }

    public function create()
    {
        // Fetch Neccesery data
        $subAccountKeys = SubAccountKey::all();

        return view('layouts.admin.forms.code.report-create', compact('subAccountKeys',));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sub_account_key' => 'required|exists:sub_account_keys,id',
            'report_key' => 'required|string|max:255',
            'name_report_key' => 'required|string|max:255',
            'fin_law' => 'required|numeric|min:0',
            'current_loan' => 'required|numeric|min:0',
        ]);

        // Set default values for nullable fields if not provided
        $validatedData['internal_increase'] = $validatedData['internal_increase'] ?? 0;
        $validatedData['unexpected_increase'] = $validatedData['unexpected_increase'] ?? 0;
        $validatedData['additional_increase'] = $validatedData['additional_increase'] ?? 0;
        $validatedData['decrease'] = $validatedData['decrease'] ?? 0;

        $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];

        $new_credit_status = $validatedData['current_loan'] + $total_increase - $validatedData['decrease'];

        // Check for existing records with the same sub_account_key and report_key
        $existingRecord = Report::where('sub_account_key', $request->input('sub_account_key'))
            ->where('report_key', $request->input('report_key'))
            ->first();

        if ($existingRecord) {
            return redirect()->back()->withErrors([
                'report_key' => 'The combination of Sub-Account Key ID and Report Key already exists.'
            ])->withInput();
        }

        // Calculate certificate-related fields
        $currentApplyTotal = CertificateData::where('report_key', $validatedData['report_key'])->sum('value_certificate');

        // Ensure early_balance is set to 0 if no previous records exist
        $early_balance = $currentApplyTotal > 0 ? $currentApplyTotal : 0;

        $deadline_balance = $early_balance - $currentApplyTotal;
        $credit = $new_credit_status - $deadline_balance;

        // Calculate law_average and law_correction
        $law_average = $validatedData['fin_law'] ? max(-100, min(100, ($deadline_balance / $validatedData['fin_law']) * 100)) : 0;
        $law_correction = $early_balance ? max(-100, min(100, ($deadline_balance / $early_balance) * 100)) : 0;

        // Create the new report
        Report::create([
            ...$validatedData,
            'total_increase' => $total_increase,
            'new_credit_status' => $new_credit_status,
            'apply' => $currentApplyTotal,
            'deadline_balance' => $deadline_balance,
            'credit' => $credit,
            'law_average' => $law_average,
            'law_correction' => $law_correction,
        ]);

        return redirect()->route('codes.create')->with('success', 'Report created successfully.');
    }

    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'sub_account_key' => 'required|exists:sub_account_keys,id',
    //         'report_key' => 'required|string|max:255',
    //         'name_report_key' => 'required|string|max:255',
    //         'fin_law' => 'required|numeric|min:0',
    //         'current_loan' => 'required|numeric|min:0',
    //     ]);

    //     // Debugging: Log validated data
    //     Log::info('Validated Data: ', $validatedData);

    //     // Find the loan using report_key and sub_account_key
    //     $loans = Loans::where('report_key', $validatedData['report_key'])
    //                   ->where('sub_account_key', $validatedData['sub_account_key'])
    //                   ->first();

    //     if (!$loans) {
    //         Log::error('Loan not found for report_key: ' . $validatedData['report_key'] . ' and sub_account_key: ' . $validatedData['sub_account_key']);
    //         return redirect()->back()->withErrors(['loan' => 'Loan not found.']);
    //     }

    //     // Calculate balances
    //     $deadline_balance = $loans->deadline_balance;
    //     $early_balance = $loans->early_balance;

    //     // Perform calculations
    //     $fin_law = $validatedData['fin_law'];
    //     $law_average = $fin_law ? max(-100, min(100, ($deadline_balance / $fin_law) * 100)) : 0;
    //     $law_correction = $early_balance ? max(-100, min(100, ($deadline_balance / $early_balance) * 100)) : 0;

    //     // Attempt to create the report
    //     try {
    //         Report::create([
    //             ...$validatedData,
    //             'law_average' => $law_average,
    //             'law_correction' => $law_correction,
    //         ]);
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors(['error' => 'Failed to create report: ' . $e->getMessage()]);
    //     }

    //     return redirect()->route('codes.index')->with('success', 'ទិន្ន័យកម្មវិធីបានបង្កើតដោយជោគជ័យ។');
    // }



    public function edit($id)
    {
        // Fetch the record by ID
        $report = Report::findOrFail($id);

        // Fetch additional data required for the form (e.g., sub-account keys)
        $subAccountKeys = SubAccountKey::all();

        // Pass the record and additional data to the view
        return view('layouts.admin.forms.code.report-edit', compact('report', 'subAccountKeys'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'sub_account_key' => 'required|exists:sub_account_keys,id',
            'report_key' => 'required|string|max:255',
            'name_report_key' => 'required|string|max:999',
            'fin_law' => 'required|numeric|min:0',
            'current_loan' => 'nullable|numeric|min:0',
        ]);

        // Find the report by ID
        $report = Report::findOrFail($id);

        // Update report fields
        $report->fill($validatedData);
        $report->current_loan = $validatedData['current_loan'] ?? $validatedData['fin_law']; // Default to fin_law if not provided

        // Fetch the sum of value_certificate from CertificateData related to the report
        $totalValueCertificate = CertificateData::where('report_key', $report->report_key)
            ->whereNotNull('value_certificate')
            ->sum('value_certificate');

        // $report->deadline_balance =   $report->early_balance + $totalValueCertificate;


        // Save the updated report
        $report->save();

        // Redirect back to the index page with success message
        return redirect()->route('codes.index', $id)->with('success', 'របាយការណ៍បានកែប្រែដោយជោគជ័យ');
    }




    public function destroy($id)
    {
        $reportKey = Report::findOrFail($id);
        $reportKey->delete();

        return redirect()->route('codes.index')->with('success', 'របាយការណ៍បានលុបដោយជោគជ័យ');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:2048',
        ]);

        try {
            Excel::import(new ReportsImport, $request->file('excel_file'));
            return redirect()->back()->with('success', 'ទិន្នន័យបានដាក់ចូលដោយជោគជ័យ');
        } catch (\Exception $e) {
            // Log error details
            Log::error('Import Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during import. Please check the file format.');
        }
    }

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
