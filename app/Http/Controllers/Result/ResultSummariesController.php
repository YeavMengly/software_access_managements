<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use App\Models\Code\Report;
use App\Models\Loans\SummaryReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResultSummariesController extends Controller
{
    public function index()
    {
        // Fetch reports (Adjust the query as needed)
        $reports = Report::all(); // Example, you can use specific filtering here

        // Calculate the totals
        $totals = $this->calculateTotals($reports);

        // Store the totals into the database
        $this->storeSummaryReport($totals);

        // Sort totals by codeId
        if (isset($totals['code']) && is_array($totals['code'])) {
            ksort($totals['code']); // Sort by key (codeId) in ascending order
        }

        return view('layouts.table.result-total-summaries-table', compact('totals'));
    }

    private function calculateTotals($reports)
    {
        // Initialize the totals array with all fields set to 0
        $totals = [
            'fin_law' => 0,
            'current_loan' => 0,
            'decrease' => 0,
            'new_credit_status' => 0,
            'early_balance' => 0,
            'apply' => 0,
            'deadline_balance' => 0,
            'total_increase' => 0,
            'code' => [],
        ];

        foreach ($reports as $report) {
            $totals['fin_law'] += $report->fin_law;
            $totals['current_loan'] += $report->current_loan;
            $totals['decrease'] += $report->decrease;
            $totals['new_credit_status'] += $report->new_credit_status;
            $totals['early_balance'] += $report->early_balance;
            $totals['apply'] += $report->apply;

            // Sum recipe
            $totalIncrease = $report->internal_increase + $report->unexpected_increase + $report->additional_increase;
            $totals['total_increase'] += $totalIncrease;
        }

        // Group reports by code
        $groupedByCode = $reports->groupBy(function ($report) {
            return $report->subAccountKey->accountKey->key->code ?? 'Unknown';
        });

        foreach ($groupedByCode as $codeId => $reportsByCode) {
            $totals['code'][$codeId] = $this->calculateSumFields($reportsByCode);
        }

        return $totals;
    }

    private function calculateSumFields($reports)
    {
        return [
            'fin_law' => $reports->sum('fin_law'),
            'current_loan' => $reports->sum('current_loan'),
            'decrease' => $reports->sum('decrease'),
            'new_credit_status' => $reports->sum('new_credit_status'),
            'early_balance' => $reports->sum('early_balance'),
            'apply' => $reports->sum('apply'),
            'total_increase' => $reports->sum('total_increase')
        ];
    }

    private function storeSummaryReport($totals)
    {
        try {
            DB::transaction(function () use ($totals) {
                foreach ($totals['code'] as $codeId => $data) {
                    try {
                        SummaryReport::updateOrCreate(
                            ['program' => $codeId],
                            [
                                'fin_law' => $data['fin_law'],
                                'current_loan' => $data['current_loan'],
                                'total_increase' => $data['total_increase'],
                                'decrease' => $data['decrease'],
                                'new_credit_status' => $data['new_credit_status'],
                                'total_early_balance' => $data['early_balance'],
                                'avg_total_early_balance' => $this->calculatePercentage($data['early_balance'], $data['new_credit_status']),
                                'total_apply' => $data['apply'],
                                'avg_total_apply' => $this->calculatePercentage($data['apply'], $data['new_credit_status']),
                                'total_sum_refer' => $data['early_balance'] + $data['apply'],
                                'avg_total_sum_refer' => $this->calculatePercentage($data['early_balance'] + $data['apply'], $data['new_credit_status']),
                                'total_remain' => $data['new_credit_status'] - ($data['early_balance'] + $data['apply']),
                                'avg_total_remain' => $this->calculatePercentage($data['new_credit_status'] - ($data['early_balance'] + $data['apply']), $data['new_credit_status']),
                            ]
                        );
                    } catch (\Exception $e) {
                        Log::error("Error storing summary for code: {$codeId}, Error: " . $e->getMessage());
                    }
                }
            });
        } catch (\Exception $e) {
            Log::error('Transaction failed: ' . $e->getMessage());
        }
    }
    

    private function calculatePercentage($part, $total)
    {
        return $total > 0 ? ($part / $total) * 100 : 0;
    }
}
