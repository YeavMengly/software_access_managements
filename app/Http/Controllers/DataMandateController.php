<?php

namespace App\Http\Controllers;

use App\Models\Code\SubAccountKey;
use App\Models\Code\Year;
use App\Models\DataMandate;
use App\Models\Mandates\Mandate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DataMandateController extends Controller
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
        $query = DataMandate::query();
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
        $dataMandates = $query->paginate($perPage);

        return view('layouts.admin.forms.code.report-mandate-index', compact('dataMandates', 'years'));
    }

    public function create()
    {
        $subAccountKeys = SubAccountKey::all();
        $dataMandates = null;
        $years = Year::all();

        return view('layouts.admin.forms.code.report-mandate-create', compact('subAccountKeys', 'dataMandates', 'years'));
    }
    /**
     * Store summary report data in DataMandate.
     *
     * @param array $totals
     * @return void
     */
    public function storeSummaryReport(array $report)
    {
        try {
            DB::transaction(function () use ($report) {
                foreach ($report['sub_account_keys'] as $subAccountKey => $data) {
                    Log::info('Processing Sub Account Key: ' . $subAccountKey);
                    Log::info('Data: ' . json_encode($data));


                    try {
                        $dataMandate = DataMandate::updateOrCreate(
                            [
                                'sub_account_key' => $subAccountKey,
                                'report_key' => $data['report_key'],
                                'date_year' => $data['date_year'],
                            ],
                            [
                                'name_report_key' => $data['name_report_key'],
                                'fin_law' => number_format($data['fin_law'], 2, '.', ''),
                                'current_loan' => number_format($data['current_loan'], 2, '.', ''),
                                'total_increase' => number_format($data['total_increase'], 2, '.', ''),
                                'new_credit_status' => number_format($data['new_credit_status'], 2, '.', ''),
                                'apply' => number_format($data['apply'] ?? 0, 2, '.', ''), // Default to 0 if null
                                'deadline_balance' => number_format($data['deadline_balance'], 2, '.', ''),
                                'credit' => number_format($data['credit'], 2, '.', ''),
                                'law_average' => number_format($data['law_average'], 2, '.', ''),
                                'law_correction' => number_format($data['law_correction'], 2, '.', ''),
                            ]
                        );

                        $this->recalculateAndSaveReport($dataMandate);
                    } catch (\Exception $e) {
                        Log::error("Error storing data mandate for sub_account_key: {$subAccountKey}, Error: " . $e->getMessage());
                        throw $e; // Re-throw to ensure rollback if needed
                    }
                }
            });
        } catch (\Exception $e) {
            Log::error('Transaction failed: ' . $e->getMessage());
            throw $e; // Optionally re-throw to propagate the error
        }
    }

    public function edit($id)
    {
        $subAccountKeys = SubAccountKey::all();
        $dataMandate = DataMandate::findOrFail($id); // Find the record to edit
        $years = Year::where('status', 'active')->get();

        return view('layouts.admin.forms.code.report-mandate-edit', compact('subAccountKeys', 'dataMandate', 'years'));
    }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'sub_account_key' => 'required|exists:sub_account_keys,sub_account_key',
    //         'report_key' => 'required|numeric',
    //         'fin_law' => 'required|numeric',
    //         'current_loan' => 'required|numeric',
    //         'name_report_key' => 'required|string',
    //         'date_year' => 'required|exists:years,id',
    //     ]);

    //     try {
    //         $dataMandate = DataMandate::findOrFail($id);
    //         $dataMandate->update([
    //             'sub_account_key' => $request->sub_account_key,
    //             'report_key' => $request->report_key,
    //             'fin_law' => $request->fin_law,
    //             'current_loan' => $request->current_loan,
    //             'name_report_key' => $request->name_report_key,
    //             'date_year' => $request->date_year,
    //         ]);

    //         return redirect()->route('data-mandates.index')->with('success', 'Data Mandate updated successfully.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors(['error' => 'Failed to update the record: ' . $e->getMessage()]);
    //     }
    // }
    public function update(Request $request, $id)
    {
        $request->validate([
            'sub_account_key' => 'required|exists:sub_account_keys,sub_account_key',
            'report_key' => 'required|numeric',
            'name_report_key' => [
                'required',
                'string',
                'regex:/^[\p{L}\p{M}\s]+$/u' // Allows Khmer and other Unicode letters with spaces
            ],
            'fin_law' => 'required|numeric',
            'current_loan' => 'required|numeric',
            'date_year' => 'required|exists:years,id',
        ], [
            'sub_account_key.required' => 'សូមបញ្ចូលលេខអនុគណនី។',
            'sub_account_key.exists' => 'លេខអនុគណនីនេះមិនមាននៅក្នុងប្រព័ន្ធទេ។',
            'report_key.required' => 'សូមបញ្ចូលលេខរាយការណ៍។',
            'report_key.numeric' => 'លេខរាយការណ៍ត្រូវតែជាលេខ។',
            'fin_law.required' => 'សូមបញ្ចូលច្បាប់ហិរញ្ញវត្ថុ។',
            'fin_law.numeric' => 'ច្បាប់ហិរញ្ញវត្ថុត្រូវតែជាលេខ។',
            'current_loan.required' => 'សូមបញ្ចូលប្រាក់កម្ចីបច្ចុប្បន្ន។',
            'current_loan.numeric' => 'ប្រាក់កម្ចីបច្ចុប្បន្នត្រូវតែជាលេខ។',
            'name_report_key.required' => 'សូមបញ្ចូលចំណាត់ថ្នាក់រាយការណ៍។',
            'name_report_key.regex' => 'ចំណាត់ថ្នាក់រាយការណ៍អាចមានតែអក្សរខ្មែរ និងចន្លោះ។',
            'date_year.required' => 'សូមជ្រើសរើសឆ្នាំ។',
            'date_year.exists' => 'ឆ្នាំដែលបានជ្រើសរើសមិនត្រឹមត្រូវ។',
        ]);

        try {
            $dataMandate = DataMandate::findOrFail($id);
            $dataMandate->update([
                'sub_account_key' => $request->sub_account_key,
                'report_key' => $request->report_key,
                'fin_law' => $request->fin_law,
                'current_loan' => $request->current_loan,
                'name_report_key' => $request->name_report_key,
                'date_year' => $request->date_year,
            ]);

            return redirect()->route('data-mandates.index')->with('success', 'ការកែប្រែបានជោគជ័យ។');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'បរាជ័យក្នុងការកែប្រែ៖ ' . $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        $dataMandate = DataMandate::findOrFail($id);
        $dataMandate->delete();

        return redirect()->route('data-mandates.index')->with('success', 'ថវិការអនុម័តបានលុបដោយជោគជ័យ');
    }

    private function recalculateAndSaveReport(DataMandate $dataMandate)
    {
        // $newApplyTotal = CertificateData::where('report_key', $report->id)->sum('value_certificate');
        $newApplyTotal = Mandate::where('report_key', $dataMandate->id)
            ->latest('created_at') // Order by latest created record
            ->value('value_mandate') ?? 0; // Get only the value_certificate column
        $dataMandate->apply = $newApplyTotal;
        $credit = $dataMandate->new_credit_status - $dataMandate->deadline_balance;
        $dataMandate->credit = $credit;
        $dataMandate->deadline_balance = $dataMandate->early_balance + $dataMandate->apply;
        $dataMandate->credit = $dataMandate->new_credit_status - $dataMandate->deadline_balance;
        $dataMandate->law_average = $dataMandate->deadline_balance > 0 ? ($dataMandate->deadline_balance / $dataMandate->fin_law) * 100 : 0;
        $dataMandate->law_correction =  $dataMandate->deadline_balance > 0 ? ($dataMandate->deadline_balance /  $dataMandate->new_credit_status) * 100 : 0;
        $dataMandate->save();
    }
}
