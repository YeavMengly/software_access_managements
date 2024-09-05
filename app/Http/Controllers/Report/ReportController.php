<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Imports\ReportsImport;
use App\Models\Certificates\CertificateData;
use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the inputs
        $codeId = $request->input('code_id');
        $accountKeyId = $request->input('account_key_id');
        $subAccountKeyId = $request->input('sub_account_key_id');
        $reportKey = $request->input('report_key');
        $date = $request->input('date'); // Date filter input

        // Start building the query
        $query = Report::query();

        // Apply filters
        if ($codeId) {
            $query->whereHas('subAccountKey.accountKey.key', function ($q) use ($codeId) {
                $q->where('code', 'like', "%$codeId%");
            });
        }

        if ($accountKeyId) {
            $query->whereHas('subAccountKey.accountKey', function ($q) use ($accountKeyId) {
                $q->where('account_key', 'like', "%$accountKeyId%");
            });
        }

        if ($subAccountKeyId) {
            $query->whereHas('subAccountKey', function ($q) use ($subAccountKeyId) {
                $q->where('sub_account_key', 'like', "%$subAccountKeyId%");
            });
        }

        if ($reportKey) {
            $query->where('report_key', 'like', "%$reportKey%");
        }

        // Apply date filter if provided
        if ($date) {
            try {
                if (strpos($date, ' - ') !== false) {
                    // Date range
                    list($startDate, $endDate) = explode(' - ', $date);
                    $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay()->toDateTimeString();
                    $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay()->toDateTimeString();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                } else {
                    // Single date
                    $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d');
                    $query->whereDate('created_at', $formattedDate);
                }
            } catch (\Exception $e) {
                // Handle invalid date format error
                Log::error('Invalid date format: ' . $e->getMessage());
                return redirect()->back()->withErrors(['date' => 'Invalid date format. Please use YYYY-MM-DD format or YYYY-MM-DD - YYYY-MM-DD for ranges.']);
            }
        }

        // Fetch the filtered and sorted data
        $reports = $query->paginate(10);

        return view('layouts.admin.forms.code.report-index', compact('reports'));
    }


    public function create()
    {
        $subAccountKeys = SubAccountKey::all();

        return view('layouts.admin.forms.code.report-create', compact('subAccountKeys'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sub_account_key' => 'required|exists:sub_account_keys,id',
            'report_key' => 'required|string|max:255',
            'name_report_key' => 'required|string|max:255',
            'fin_law' => 'required|numeric',
            'internal_increase' => 'nullable|numeric',
            'unexpected_increase' => 'nullable|numeric',
            'additional_increase' => 'nullable|numeric',
            'decrease' => 'nullable|numeric',
        ]);


        // Set 'decrease' to 0 if it's not provided
        $validatedData['internal_increase'] = $validatedData['internal_increase'] ?? 0;
        $validatedData['unexpected_increase'] = $validatedData['unexpected_increase'] ?? 0;
        $validatedData['additional_increase'] = $validatedData['additional_increase'] ?? 0;
        $validatedData['decrease'] = $validatedData['decrease'] ?? 0;

        // Set current_loan equal to fin_law
        $validatedData['current_loan'] = $validatedData['fin_law'];

        // Calculate totals of totals_increase
        $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];

        // Calculate new credit status
        $new_credit_status = $validatedData['current_loan'] + $total_increase - $validatedData['decrease'];

        // Check if a record with the same sub_account_key and report_key already exists
        $existingRecord = Report::where('sub_account_key', $request->input('sub_account_key'))
            ->where('report_key', $request->input('report_key'))
            ->first();

        if ($existingRecord) {
            return redirect()->back()->withErrors([
                'report_key' => 'The combination of Sub-Account Key ID and Report Key already exists.'
            ])->withInput();
        }

        $early_balance = $validatedData['fin_law'];

        // Get the current apply total for the report key
        $currentApplyTotal = CertificateData::where('report_key', $validatedData['report_key'])->sum('value_certificate');
        $newApplyTotal = $currentApplyTotal;

        // Calculate Deadline_Balance
        $deadline_balance =   $early_balance - $newApplyTotal;

        // Calculate Remain Loan
        $credit = $new_credit_status -  $deadline_balance;

        // Calculate law_correction
        $law_average = $deadline_balance /  $validatedData['fin_law'];
        $law_correction =  $deadline_balance /  $early_balance;


        // Create the new record
        Report::create([
            ...$validatedData,
            'total_increase' => $total_increase,
            'new_credit_status' => $new_credit_status,
            'early_balance' => $early_balance,
            'apply' => $newApplyTotal,
            'deadline_balance' => $deadline_balance,
            'credit' => $credit,
            'law_average' => $law_average,
            'law_correction' => $law_correction
        ]);

        return redirect()->route('codes.index')->with('success', 'ទិន្ន័យកម្មវិធីបានបង្កើតដោយជោគជ័យ។');
    }

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
        $validatedData = $request->validate([
            'sub_account_key' => 'required|exists:sub_account_keys,id',
            'report_key' => 'required|string|max:255',
            'name_report_key' => 'required|string|max:255',
            'fin_law' => 'required|numeric',
            // 'current_loan' => 'nullable|numeric',
            'internal_increase' => 'nullable|numeric',
            'unexpected_increase' => 'nullable|numeric',
            'additional_increase' => 'nullable|numeric',
            'decrease' => 'nullable|numeric',
        ]);

        // Find the report by ID
        $report = Report::findOrFail($id);

        // Update fields
        $report->sub_account_key = $validatedData['sub_account_key'];
        $report->report_key = $validatedData['report_key'];
        $report->name_report_key = $validatedData['name_report_key'];
        $report->fin_law = $validatedData['fin_law'];
        $report->current_loan = $validatedData['current_loan'] ?? $validatedData['fin_law']; // Default to fin_law if not provided
        $report->internal_increase = $validatedData['internal_increase'] ?? 0;
        $report->unexpected_increase = $validatedData['unexpected_increase'] ?? 0;
        $report->additional_increase = $validatedData['additional_increase'] ?? 0;
        $report->decrease = $validatedData['decrease'] ?? 0;

        // Calculate totals
        $total_increase = $report->internal_increase + $report->unexpected_increase + $report->additional_increase;
        $new_credit_status = $report->current_loan + $total_increase - $report->decrease;

        // Get the updated apply total for the report key
        $currentApplyTotal = CertificateData::where('report_key', $report->report_key)->sum('value_certificate');
        $deadline_balance = $report->fin_law - $currentApplyTotal; // Adjust calculation

        // Update the report with new values
        $report->total_increase = $total_increase;
        $report->new_credit_status = $new_credit_status;
        $report->apply = $currentApplyTotal;
        $report->deadline_balance = $deadline_balance;
        $report->credit = $new_credit_status - $deadline_balance;
        $report->law_average = $deadline_balance / ($report->fin_law ?: 1); // Avoid division by zero
        $report->law_correction = $new_credit_status / ($report->fin_law ?: 1); // Avoid division by zero

        // Debugging output
        Log::info('Updating report', [
            'id' => $id,
            'total_increase' => $total_increase,
            'new_credit_status' => $new_credit_status,
            'currentApplyTotal' => $currentApplyTotal,
            'deadline_balance' => $deadline_balance,
            'credit' => $report->credit,
            'law_average' => $report->law_average,
            'law_correction' => $report->law_correction,
        ]);

        $report->save();

        return redirect()->route('codes.index')->with('success', 'Record updated successfully');
    }


    public function destroy($id)
    {
        $reportKey = Report::findOrFail($id);
        $reportKey->delete();

        return redirect()->route('codes.index')->with('success', 'Report Key deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:2048',
        ]);
    
        Excel::import(new ReportsImport, $request->file('excel_file'));
    
        return redirect()->back()->with('success', 'Data imported successfully.');
    }
}
