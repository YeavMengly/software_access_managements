<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Imports\ReportsImport;
use App\Models\Certificates\CertificateData;
use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use App\Models\Code\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $codeId = $request->input('code_id');
        $accountKeyId = $request->input('account_key_id');
        $subAccountKeyId = $request->input('sub_account_key_id');
        $reportKey = $request->input('report_key');
        $date = $request->input('date');
        $perPage = $request->input('per_page', 25);
        $sortColumn = $request->input('sort_column', 'created_at');
        $sortDirection = $request->input('sort_direction', 'asc');
        $query = Report::query();
        $years = Year::all();

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

        if ($date) {
            try {
                if (strpos($date, ' - ') !== false) {
                    [$startDate, $endDate] = explode(' - ', $date);
                    $query->whereBetween('created_at', [
                        Carbon::createFromFormat('Y-m-d', trim($startDate))->startOfDay(),
                        Carbon::createFromFormat('Y-m-d', trim($endDate))->endOfDay()
                    ]);
                } else {
                    $query->whereDate('created_at', Carbon::createFromFormat('Y-m-d', $date)->toDateString());
                }
            } catch (\Exception $e) {
                Log::error('Invalid date format: ' . $e->getMessage());
                return redirect()->back()->withErrors(['date' => 'Invalid date format. Please use YYYY-MM-DD or a date range (YYYY-MM-DD - YYYY-MM-DD).']);
            }
        }
        $query->orderBy($sortColumn, $sortDirection);
        $reports = $query->paginate($perPage);

        return view('layouts.admin.forms.code.report-index', compact('reports', 'years'));
    }

    public function create()
    {
        $subAccountKeys = SubAccountKey::all();
        $report = null;
        $years = Year::all();  // Fetch all years from the database

        return view('layouts.admin.forms.code.report-create', compact('subAccountKeys', 'report', 'years'));
    }

    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'sub_account_key' => 'required|exists:sub_account_keys,id',
        //     'report_key' => 'required|string|max:255',
        //     'name_report_key' => 'required|string|max:255',
        //     'fin_law' => 'required|numeric|min:0',
        //     'current_loan' => 'required|numeric|min:0',
        //     'date_year' => 'required|exists:years,id',
        // ]);

        // // dd($validatedData);

        // // Retrieve the selected year
        // $year = Year::find($validatedData['date_year']);
        // if (!$year) {
        //     return redirect()->back()->withErrors(['date_year' => 'Invalid year selected.'])->withInput();
        // }

        // // Check if the selected year matches the current year
        // $currentYear = now()->year; // Get the current year
        // if ($year->date_year->year !== $currentYear) {
        //     return redirect()->back()->withErrors([
        //         'date_year' => 'The selected year does not match the current year (' . $currentYear . ').',
        //     ])->withInput();
        // }
        $validatedData = $request->validate([
            'sub_account_key' => 'required|exists:sub_account_keys,id',
            'report_key' => 'required|string|max:255|unique:reports,report_key,NULL,id,sub_account_key,' . $request->input('sub_account_key'),
            'name_report_key' => 'required|string|max:255',
            'fin_law' => 'required|numeric|min:0',
            'current_loan' => 'required|numeric|min:0',
            'date_year' => 'required|exists:years,id',
        ], [
            'sub_account_key.required' => 'សូមជ្រើសរើសគណនីបន្ទាប់។',
            'report_key.unique' => 'គន្លឹះរបាយការណ៍នេះមានរួចហើយសម្រាប់គណនីបន្ទាប់នេះ។',
            'date_year.required' => 'សូមជ្រើសរើសឆ្នាំ។',
            'fin_law.numeric' => 'តម្លៃច្បាប់ហិរញ្ញវត្ថុត្រូវតែជាលេខ។',
        ]);
    
        // Retrieve the selected year
        $year = Year::find($validatedData['date_year']);
        if (!$year) {
            return redirect()->back()->withErrors(['date_year' => 'ឆ្នាំដែលបានជ្រើសរើសមិនត្រឹមត្រូវ។'])->withInput();
        }
    
        // Check if the selected year matches the current year
        $currentYear = now()->year; // Get the current year
        if ($year->date_year->year !== $currentYear) {
            return redirect()->back()->withErrors([
                'date_year' => 'ឆ្នាំដែលបានជ្រើសរើសមិនដូចនឹងឆ្នាំបច្ចុប្បន្ន (' . $currentYear . ')។',
            ])->withInput();
        }
    
        // Additional validations for logical consistency
        if ($request->input('current_loan') < 0) {
            return redirect()->back()->withErrors([
                'current_loan' => 'ចំនួនទុនបងវិញមិនអាចមានតម្លៃអវិជ្ជមាន។',
            ])->withInput();
        }
    
        if ($request->input('fin_law') < $request->input('current_loan')) {
            return redirect()->back()->withErrors([
                'fin_law' => 'ច្បាប់ហិរញ្ញវត្ថុត្រូវតែធំជាងឬស្មើចំនួនទុនបងវិញ។',
            ])->withInput();
        }

        // Default values for optional fields
        $validatedData['internal_increase'] = $validatedData['internal_increase'] ?? 0;
        $validatedData['unexpected_increase'] = $validatedData['unexpected_increase'] ?? 0;
        $validatedData['additional_increase'] = $validatedData['additional_increase'] ?? 0;
        $validatedData['decrease'] = $validatedData['decrease'] ?? 0;
        $validatedData['editorial'] = $validatedData['editorial'] ?? 0;

        // Calculate totals and balances
        $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];
        $new_credit_status = $validatedData['current_loan'] + $total_increase - $validatedData['decrease'] - $validatedData['editorial'];

        // Check for duplicate entries
        $existingRecord = Report::where('sub_account_key', $request->input('sub_account_key'))
            ->where('report_key', $request->input('report_key'))
            ->where('date_year', $request->input('date_year'))
            ->exists();

        if ($existingRecord) {
            return redirect()->back()->withErrors([
                'report_key' => 'The combination of Sub-Account Key ID and Report Key already exists.',
            ])->withInput();
        }

        // Fetch totals from CertificateData
        $currentApplyTotal = CertificateData::where('report_key', $validatedData['report_key'])->sum('value_certificate');
        $early_balance = $currentApplyTotal > 0 ? $currentApplyTotal : 0;
        $deadline_balance = $early_balance + $currentApplyTotal;
        $credit = $new_credit_status - $deadline_balance;
        $law_average = $validatedData['fin_law'] ? max(-100, min(100, ($deadline_balance / $validatedData['fin_law']) * 100)) : 0;
        $law_correction = $early_balance ? max(-100, min(100, ($deadline_balance / $early_balance) * 100)) : 0;

        // Create the report
        $report = Report::create([
            ...$validatedData,
            'date_year' => $year->id,
            'total_increase' => $total_increase,
            'new_credit_status' => $new_credit_status,
            'apply' => $currentApplyTotal,
            'deadline_balance' => $deadline_balance,
            'credit' => $credit,
            'law_average' => $law_average,
            'law_correction' => $law_correction,
        ]);

        // Perform additional recalculations
        $this->recalculateAndSaveReport($report);

        return redirect()->route('codes.create')->with('success', 'ថវិការអនុម័តបានបញ្ចូលដោយជោគជ័យ។');
    }

    public function edit($id)
    {
        $report = Report::findOrFail($id);
        $subAccountKeys = SubAccountKey::all();

        return view('layouts.admin.forms.code.report-edit', compact('report', 'subAccountKeys'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'sub_account_key' => 'required|exists:sub_account_keys,id',
            'report_key' => 'required|string|max:255',
            'name_report_key' => 'required|string|max:255',
            'fin_law' => 'required|numeric|min:0',
            'current_loan' => 'required|numeric|min:0',
        ]);
        $report = Report::findOrFail($id);
        $loan = $report->loans;
        $validatedData['internal_increase'] = $loan->internal_increase ?? 0;
        $validatedData['unexpected_increase'] = $loan->unexpected_increase ?? 0;
        $validatedData['additional_increase'] = $loan->additional_increase ?? 0;
        $validatedData['decrease'] = $loan->decreas ?? 0;
        $validatedData['editorial'] = $loan->editorial ?? 0;
        $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];
        $new_credit_status = $validatedData['current_loan'] + $total_increase - $validatedData['decrease'] - $validatedData['editorial'];

        $currentApplyTotal = CertificateData::where('report_key', $validatedData['report_key'])->sum('value_certificate');
        $early_balance = $currentApplyTotal > 0 ? $currentApplyTotal : 0;
        $deadline_balance = $early_balance + $currentApplyTotal;
        $credit = $new_credit_status - $deadline_balance;

        $law_average = $validatedData['fin_law'] ? max(-100, min(100, ($deadline_balance / $validatedData['fin_law']) * 100)) : 0;
        $law_correction = $early_balance ? max(-100, min(100, ($deadline_balance / $early_balance) * 100)) : 0;

        $report->update([
            ...$validatedData,
            'total_increase' => $total_increase,
            'new_credit_status' => $new_credit_status,
            'apply' => $currentApplyTotal,
            'deadline_balance' => $deadline_balance,
            'credit' => $credit,
            'law_average' => $law_average,
            'law_correction' => $law_correction,
        ]);
        $this->recalculateAndSaveReport($report);

        return redirect()->route('codes.index')->with('success', 'ថវិការអនុម័តបានកែដោយជោគជ័យ។');
    }

    public function destroy($id)
    {
        $reportKey = Report::findOrFail($id);
        $reportKey->delete();

        return redirect()->route('codes.index')->with('success', 'ថវិការអនុម័តបានលុបដោយជោគជ័យ');
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

    private function recalculateAndSaveReport(Report $report)
    {
        $newApplyTotal = CertificateData::where('report_key', $report->id)->sum('value_certificate');
        $report->apply = $newApplyTotal;
        $report->deadline_balance = $report->early_balance + $report->apply;
        $credit = $report->new_credit_status - $report->deadline_balance;
        $report->credit = $credit;

        $report->save();
    }
}
