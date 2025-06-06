<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataMandateController;
use App\Imports\ReportsImport;
use App\Models\Certificates\CertificateData;
use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use App\Models\Code\Year;
use App\Models\DataMandate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $years = Year::all();

        return view('layouts.admin.forms.code.report-create', compact('subAccountKeys', 'report', 'years'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sub_account_key' => 'required|exists:sub_account_keys,sub_account_key',
            'report_key' => 'required|string|max:255',
            'name_report_key' => 'nullable|string',
            'fin_law' => 'required|numeric|min:0',
            'current_loan' => 'required|numeric|min:0',
            'date_year' => 'required|exists:years,id',
        ], [
            'sub_account_key.required' => 'សូមបញ្ចូលលេខអនុគណនី។',
            'sub_account_key.exists' => 'លេខអនុគណនីនេះមិនមាននៅក្នុងប្រព័ន្ធទេ។',
            'report_key.required' => 'សូមបញ្ចូលលេខរាយការណ៍។',
            'report_key.numeric' => 'លេខរាយការណ៍ត្រូវតែជាលេខ។',
            'fin_law.required' => 'សូមបញ្ចូលច្បាប់ហិរញ្ញវត្ថុ។',
            'fin_law.numeric' => 'ច្បាប់ហិរញ្ញវត្ថុត្រូវតែជាលេខ។',
            'current_loan.required' => 'សូមបញ្ចូលប្រាក់បច្ចុប្បន្ន។',
            'current_loan.numeric' => 'ប្រាក់កម្ចីបច្ចុប្បន្នត្រូវតែជាលេខ។',
            'name_report_key.required' => 'សូមបញ្ចូលចំណាត់ថ្នាក់រាយការណ៍។',
            'name_report_key.regex' => 'ចំណាត់ថ្នាក់រាយការណ៍អាចមានតែអក្សរខ្មែរ និងចន្លោះ។',
            'date_year.required' => 'សូមជ្រើសរើសឆ្នាំ។',
            'date_year.exists' => 'ឆ្នាំដែលបានជ្រើសរើសមិនត្រឹមត្រូវ។',
        ]);

        $year = Year::find($validatedData['date_year']);
        if (!$year) {
            return redirect()->back()->withErrors(['date_year' => 'ឆ្នាំដែលបានជ្រើសរើសមិនត្រឹមត្រូវ។'])->withInput();
        }

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

        $validatedData['internal_increase'] = $validatedData['internal_increase'] ?? 0;
        $validatedData['unexpected_increase'] = $validatedData['unexpected_increase'] ?? 0;
        $validatedData['additional_increase'] = $validatedData['additional_increase'] ?? 0;
        $validatedData['decrease'] = $validatedData['decrease'] ?? 0;
        $validatedData['editorial'] = $validatedData['editorial'] ?? 0;

        $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];
        $new_credit_status = $validatedData['current_loan'] + $total_increase - $validatedData['decrease'] - $validatedData['editorial'];

        $existingRecord = Report::where('sub_account_key', $request->input('sub_account_key'))
            ->where('report_key', $request->input('report_key'))
            ->where('date_year', $request->input('date_year'))
            ->exists();

        if ($existingRecord) {
            return redirect()->back()->withErrors([
                'report_key' => 'The combination of Sub-Account Key ID and Report Key already exists.',
            ])->withInput();
        }

        $currentApplyTotal = CertificateData::where('report_key', $validatedData['report_key'])->sum('value_certificate');
        $early_balance = $currentApplyTotal > 0 ? $currentApplyTotal : 0;
        $deadline_balance = $early_balance + $currentApplyTotal;
        $credit = $new_credit_status - $deadline_balance;
        $law_average = $validatedData['fin_law'] ? max(-100, min(100, ($deadline_balance / $validatedData['fin_law']) * 100)) : 0;
        $law_correction = $early_balance ? max(-100, min(100, ($deadline_balance / $early_balance) * 100)) : 0;

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

        $this->recalculateAndSaveReport($report);

        $totals = [
            'sub_account_keys' => [
                $validatedData['sub_account_key'] => [
                    'report_key' => $validatedData['report_key'],
                    'date_year' => $validatedData['date_year'],
                    'name_report_key' => $validatedData['name_report_key'],
                    'fin_law' => $validatedData['fin_law'],
                    'current_loan' => $validatedData['current_loan'],
                    'total_increase' => $total_increase,
                    'new_credit_status' => $new_credit_status,
                    'apply' => $currentApplyTotal ?? 0,
                    'deadline_balance' => $deadline_balance,
                    'credit' => $credit,
                    'law_average' => $law_average,
                    'law_correction' => $law_correction,
                ],
            ],
        ];

        try {
            app(DataMandateController::class)->storeSummaryReport($totals);
        } catch (\Exception $e) {
            Log::error('Failed to store summary report: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to store summary report. Please check logs.'])->withInput();
        }

        return redirect()->route('codes.create')->with('success', 'ថវិការអនុម័តបានបញ្ចូលដោយជោគជ័យ។');
    }

    public function edit($id)
    {
        $report = Report::findOrFail($id);
        $subAccountKeys = SubAccountKey::all();
        $years = Year::all();

        return view('layouts.admin.forms.code.report-edit', compact('report', 'subAccountKeys', 'years'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'sub_account_key' => 'required|exists:sub_account_keys,sub_account_key',
            'report_key' => 'required|string|max:255',
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

        $year = Year::find($validatedData['date_year']);
        if (!$year) {
            return redirect()->back()->withErrors(['date_year' => 'ឆ្នាំដែលបានជ្រើសរើសមិនត្រឹមត្រូវ។'])->withInput();
        }

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

        $report = Report::findOrFail($id);

        $validatedData['internal_increase'] = $validatedData['internal_increase'] ?? 0;
        $validatedData['unexpected_increase'] = $validatedData['unexpected_increase'] ?? 0;
        $validatedData['additional_increase'] = $validatedData['additional_increase'] ?? 0;
        $validatedData['decrease'] = $validatedData['decrease'] ?? 0;
        $validatedData['editorial'] = $validatedData['editorial'] ?? 0;

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
            'date_year' => $year->id,
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
            Log::error('Import Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during import. Please check the file format.');
        }
    }

    private function recalculateAndSaveReport(Report $report)
    {
        // $newApplyTotal = CertificateData::where('report_key', $report->id)->sum('value_certificate');
        $newApplyTotal = CertificateData::where('report_key', $report->id)
            ->latest('created_at') // Order by latest created record
            ->value('value_certificate') ?? 0; // Get only the value_certificate column
        $report->apply = $newApplyTotal;
        $credit = $report->new_credit_status - $report->deadline_balance;
        $report->credit = $credit;
        $report->deadline_balance = $report->early_balance + $report->apply;
        $report->credit = $report->new_credit_status - $report->deadline_balance;
        $report->law_average = $report->deadline_balance > 0 ? ($report->deadline_balance / $report->fin_law) * 100 : 0;
        $report->law_correction =  $report->deadline_balance > 0 ? ($report->deadline_balance /  $report->new_credit_status) * 100 : 0;

        $report->save();
    }
}
