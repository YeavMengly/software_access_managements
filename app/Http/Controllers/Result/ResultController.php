<?php

namespace App\Http\Controllers\Result;

use App\Exports\Results\ResultExport;
use App\Http\Controllers\Controller;
use App\Models\Code\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::query();

        // Apply filters
        $this->applyFilters($query, $request);

        // Get filtered results
        $results = $query->get();

        // Check if the user clicked the export button
        if ($request->has('export')) {
            return Excel::download(new ResultExport($query->get()), 'results.xlsx');
        }

        // Calculate the totals
        $totals = $this->calculateTotals($results);

        return view('layouts.table.result', compact('totals', 'results'));
    }

    public function export(Request $request)
    {
        try {
            $query = Report::query();

            // Apply filters
            $this->applyFilters($query, $request);

            // Retrieve the filtered data
            $results = $query->get();

            // Export the filtered data
            return Excel::download(new ResultExport($results), 'reports.xlsx');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function exportPdf(Request $request)
    {
        try {
            $query = Report::query();

            // Apply filters
            $this->applyFilters($query, $request);

            // Generate PDF
            $pdf = Pdf::loadView('layouts.pdf.result_pdf', [
                'reports' => $query->get(),
                'totals' => $this->calculateTotals($query->get()),
            ])->setPaper('a2', 'landscape')
                ->setOption('zoom', '100%')
                ->setOptions([
                    'margin-top' => 5,
                    'margin-bottom' => 5,
                    'margin-left' => 0,
                    'margin-right' => 5,
                ]);

            return $pdf->download('results.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function applyDateFilter($query, $date)
    {
        // Apply date filter
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
    }
    private function applyFilters($query, Request $request)
    {

        $codeId = $request->input('code_id');
        $accountKeyId = $request->input('account_key_id');
        $subAccountKeyId = $request->input('sub_account_key_id');
        $reportKey = $request->input('report_key');
        $date = $request->input('date');

        $this->applyCodeFilter($query, $request->input('code_id'), 'code', 2, 'subAccountKey.accountKey.key');
        $this->applyCodeFilter($query, $request->input('account_key_id'), 'account_key', 4, 'subAccountKey.accountKey');
        $this->applyCodeFilter($query, $request->input('sub_account_key_id'), 'sub_account_key', 5, 'subAccountKey');
        $this->applyCodeFilter($query, $request->input('report_key'), 'report_key', 7);

        // Apply date filter
        $this->applyDateFilter($query, $request->input('date'));
        // Check if any filter input is present and apply date filter
        if ($codeId || $accountKeyId || $subAccountKeyId || $reportKey) {
            $this->applyDateFilter($query, $date);
        }
    }

    private function applyCodeFilter($query, $input, $column, $length, $relation = null)
    {
        if ($input) {
            $firstDigits = substr($input, 0, $length);
            $condition = function ($q) use ($firstDigits, $column) {
                $q->where($column, 'like', $firstDigits . '%');
            };

            if ($relation) {
                $query->whereHas($relation, $condition);
            } else {
                $query->where($column, 'like', $firstDigits . '%');
            }
        }
    }

    // private function calculateTotals($reports)
    // {
    //     $totals = [
    //         'fin_law' => 0,
    //         'current_loan' => 0,
    //         'internal_increase' => 0,
    //         'unexpected_increase' => 0,
    //         'additional_increase' => 0,
    //         'decrease' => 0,
    //         'editorial' => 0,
    //         'new_credit_status' => 0,
    //         'early_balance' => 0,
    //         'apply' => 0,
    //         'deadline_balance' => 0,
    //         'credit' => 0,
    //         'law_average' => 0,
    //         'law_correction' => 0,
    //         'total_increase' => 0,
    //         'total_balance' => 0,
    //         'sub_account_amount' => 0, // Total for subAccountKey amounts
    //         'account_amount' => 0, // Total for accountKey amounts
    //         'fin_law_by_code' => [], // Total of fin_law grouped by code
    //         'code' => [],
    //         'accountKey' => [],
    //         'subAccountKey' => [],


    //         'total_by_code' => [],
    //         'total_by_account_key' => [],
    //         'total_by_sub_account_key' => [],
    //         'total_by_report_key' => [],
    //     ];

    //     // Group reports by code
    //     // $groupedReports = $reports->groupBy('code');

    //     // foreach ($groupedReports as $code => $group) {
    //     //     $finLawTotal = $group->sum('fin_law');
    //     //     $amountTotal = $group->sum('amount');
    //     //     $totals['fin_law_by_code'][$code] = $finLawTotal;

    //     //     $totals['fin_law_by_code'][$code] = $finLawTotal;
    //     //     $totals['amount_by_code'][$code] = $amountTotal;
    //     // }

    //     foreach ($reports as $report) {
    //         $totals['fin_law'] += $report->fin_law;
    //         $totals['current_loan'] += $report->current_loan;
    //         $totals['internal_increase'] += $report->internal_increase;
    //         $totals['unexpected_increase'] += $report->unexpected_increase;
    //         $totals['additional_increase'] += $report->additional_increase;
    //         $totals['decrease'] += $report->decrease;
    //         $totals['editorial'] += $report->editorial;
    //         $totals['new_credit_status'] += $report->new_credit_status;
    //         $totals['early_balance'] += $report->early_balance;
    //         $totals['apply'] += $report->apply;
    //         $totals['deadline_balance'] += $report->deadline_balance;
    //         $totals['credit'] += $report->credit;
    //         $totals['law_average'] += $report->law_average;
    //         $totals['law_correction'] += $report->law_correction;

    //         $totalIncrease = $report->internal_increase + $report->unexpected_increase + $report->additional_increase;
    //         $totals['total_increase'] += $totalIncrease;
    //         // $totals['total_balance'] += ($totalIncrease - $report->decrease);

    //         // Sum subAccountKey amounts
    //         // if ($report->subAccountKey) {
    //         //     $totals['sub_account_amount'] += $report->subAccountKey->amount ?? 0;
    //         // }

    //         // Sum accountKey amounts
    //         // if ($report->subAccountKey && $report->subAccountKey->accountKey) {
    //         //     $totals['account_amount'] += $report->subAccountKey->accountKey->amount ?? 0;
    //         // }
    //     }


    //     // Group reports by code_id
    //     $groupedByCode = $reports->groupBy(function ($report) {
    //         return $report->subAccountKey->accountKey->key->code ?? 'Unknown';
    //     });

    //     foreach ($groupedByCode as $codeId => $reportsByCode) {
    //         $totals['code'][$codeId] = $reportsByCode->sum('fin_law'); // Adjust 'amount' as necessary

    //         // Group by accountKey within each codeId
    //         $groupedByAccountKey = $reportsByCode->groupBy(function ($report) {
    //             return $report->subAccountKey->accountKey->account_key ?? 'Unknown';
    //         });

    //         foreach ($groupedByAccountKey as $accountKeyId => $reportsByAccountKey) {
    //             $totals['accountKey'][$accountKeyId] = $reportsByAccountKey->sum('fin_law'); // Adjust 'amount' as necessary

    //             // Group by subAccountKey within each accountKey
    //             $groupedBySubAccountKey = $reportsByAccountKey->groupBy(function ($report) {
    //                 return $report->subAccountKey->sub_account_key ?? 'Unknown';
    //             });

    //             foreach ($groupedBySubAccountKey as $subAccountKeyId => $reportsBySubAccountKey) {
    //                 $totals['subAccountKey'][$subAccountKeyId] = $reportsBySubAccountKey->sum('fin_law'); // Adjust 'amount' as necessary
    //             }
    //         }
    //     }

    //     return $totals;
    // }

    private function calculateTotals($reports)
    {
        // Initialize the totals array with all fields set to 0
        $totals = [
            'fin_law' => 0,
            'current_loan' => 0,
            'internal_increase' => 0,
            'unexpected_increase' => 0,
            'additional_increase' => 0,
            'decrease' => 0,
            'editorial' => 0,
            'new_credit_status' => 0,
            'early_balance' => 0,
            'apply' => 0,
            'deadline_balance' => 0,
            'credit' => 0,
            'law_average' => 0,
            'law_correction' => 0,
            'total_increase' => 0,
            'code' => [],
            'accountKey' => [],
            'subAccountKey' => [],
        ];

        foreach ($reports as $report) {
            $totals['fin_law'] += $report->fin_law;
            $totals['current_loan'] += $report->current_loan;
            $totals['internal_increase'] += $report->internal_increase;
            $totals['unexpected_increase'] += $report->unexpected_increase;
            $totals['additional_increase'] += $report->additional_increase;
            $totals['decrease'] += $report->decrease;
            $totals['editorial'] += $report->editorial;
            $totals['new_credit_status'] += $report->new_credit_status;
            $totals['early_balance'] += $report->early_balance;
            $totals['apply'] += $report->apply;
            $totals['deadline_balance'] += $report->deadline_balance;
            $totals['credit'] += $report->credit;
            $totals['law_average'] += $report->law_average;
            $totals['law_correction'] += $report->law_correction;

            $totalIncrease = $report->internal_increase + $report->unexpected_increase + $report->additional_increase;
            $totals['total_increase'] += $totalIncrease;
        }

        // Group reports by code
        $groupedByCode = $reports->groupBy(function ($report) {
            return $report->subAccountKey->accountKey->key->code ?? 'Unknown';
        });

        foreach ($groupedByCode as $codeId => $reportsByCode) {
            $totals['code'][$codeId] = $this->calculateSumFields($reportsByCode);
            $totals['code'][$codeId]['name'] = $reportsByCode->first()->subAccountKey->accountKey->key->name ?? 'Unknown';


            // Group by accountKey within each codeId
            $groupedByAccountKey = $reportsByCode->groupBy(function ($report) {
                return $report->subAccountKey->accountKey->account_key ?? 'Unknown';
            });

            foreach ($groupedByAccountKey as $accountKeyId => $reportsByAccountKey) {
                $totals['accountKey'][$codeId][$accountKeyId] = $this->calculateSumFields($reportsByAccountKey);
                $totals['accountKey'][$codeId][$accountKeyId]['name_account_key'] = $reportsByAccountKey->first()->subAccountKey->accountKey->name_account_key ?? 'Unknown';


                // Group by subAccountKey within each accountKey
                $groupedBySubAccountKey = $reportsByAccountKey->groupBy(function ($report) {
                    return $report->subAccountKey->sub_account_key ?? 'Unknown';
                });

                foreach ($groupedBySubAccountKey as $subAccountKeyId => $reportsBySubAccountKey) {
                    $totals['subAccountKey'][$codeId][$accountKeyId][$subAccountKeyId] = $this->calculateSumFields($reportsBySubAccountKey);
                    $totals['subAccountKey'][$codeId][$accountKeyId][$subAccountKeyId]['name_sub_account_key'] = $reportsBySubAccountKey->first()->subAccountKey->name_sub_account_key ?? 'Unknown';
                }
            }
        }

        return $totals;
    }

    private function calculateSumFields($reports)
    {
        return [
            'fin_law' => $reports->sum('fin_law'),
            'current_loan' => $reports->sum('current_loan'),
            'internal_increase' => $reports->sum('internal_increase'),
            'unexpected_increase' => $reports->sum('unexpected_increase'),
            'additional_increase' => $reports->sum('additional_increase'),
            'decrease' => $reports->sum('decrease'),
            'editorial' => $reports->sum('editorial'),
            'new_credit_status' => $reports->sum('new_credit_status'),
            'early_balance' => $reports->sum('early_balance'),
            'apply' => $reports->sum('apply'),
            'deadline_balance' => $reports->sum('deadline_balance'),
            'credit' => $reports->sum('credit'),
            'law_average' => $reports->sum('law_average'),
            'law_correction' => $reports->sum('law_correction'),
        ];
    }
}
