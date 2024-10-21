<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use App\Models\Code\Report;
use App\Models\Loans\SummaryReport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResultApplyController extends Controller
{
    public function index()
    {
        // Fetch reports 
        $reports = Report::all(); 

        // Calculate the totals
        $totals = $this->calculateTotals($reports);

        // Store the totals into the database
        $this->storeSummaryReport($totals);

        if (isset($totals['code']) && is_array($totals['code'])) {
            ksort($totals['code']); // Sort by key (codeId) in ascending order
        }

        return view('layouts.table.result-applied-table', compact('totals'));
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
            'total_increase' => 0,
            'report_key' => [], 
            'total_sums' => [ 
                'fin_law' => 0,
                'current_loan' => 0,
                'decrease' => 0,
                'new_credit_status' => 0,
                'early_balance' => 0,
                'apply' => 0,
                'total_increase' => 0,
                'total_sum_refer' => 0,
                'total_remain' => 0,
            ],
        ];
    
        foreach ($reports as $report) {
            $totals['fin_law'] += $report->fin_law;
            $totals['current_loan'] += $report->current_loan;
            $totals['decrease'] += $report->decrease;
            $totals['new_credit_status'] += $report->new_credit_status;
            $totals['early_balance'] += $report->early_balance;
            $totals['apply'] += $report->apply;
    
            // Sum increase
            $totalIncrease = $report->internal_increase + $report->unexpected_increase + $report->additional_increase;
            $totals['total_increase'] += $totalIncrease;
        }
    
        // Group reports by reportKeyId
        $groupedByReportKeyId = $reports->groupBy(function ($report) {
            return $report->report_key ?? 'Unknown'; // Adjust this line as necessary based on your relationship
        });
    
        foreach ($groupedByReportKeyId as $reportKeyId => $reportsByKey) {
            $totals['report_key'][$reportKeyId] = $this->calculateSumFields($reportsByKey);
    
            // Update the total sums
            $totals['total_sums']['fin_law'] += $totals['report_key'][$reportKeyId]['fin_law'];
            $totals['total_sums']['current_loan'] += $totals['report_key'][$reportKeyId]['current_loan'];
            $totals['total_sums']['decrease'] += $totals['report_key'][$reportKeyId]['decrease'];
            $totals['total_sums']['new_credit_status'] += $totals['report_key'][$reportKeyId]['new_credit_status'];
            $totals['total_sums']['early_balance'] += $totals['report_key'][$reportKeyId]['early_balance'];
            $totals['total_sums']['apply'] += $totals['report_key'][$reportKeyId]['apply'];
            $totals['total_sums']['total_increase'] += $totals['report_key'][$reportKeyId]['total_increase'];
            $totals['total_sums']['total_sum_refer'] += $totals['report_key'][$reportKeyId]['early_balance'] + $totals['report_key'][$reportKeyId]['apply'];
            $totals['total_sums']['total_remain'] += $totals['report_key'][$reportKeyId]['new_credit_status'] - ($totals['report_key'][$reportKeyId]['early_balance'] + $totals['report_key'][$reportKeyId]['apply']);
        }

             // Sort the report_key totals by prefix (from 000 to 999)
             $totals['report_key'] = collect($totals['report_key'])->sortKeys();
    
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
                foreach ($totals['report_key'] as $reportKeyId => $data) {
                    try {
                        // Insert or update the result_apply table
                        DB::table('result_apply')->updateOrInsert(
                            ['report_key' => $reportKeyId], // Assuming you have a foreign key to identify each report
                            [
                                'fin_law' => $data['fin_law'],
                                'current_loan' => $data['current_loan'],
                                'decrease' => $data['decrease'],
                                'new_credit_status' => $data['new_credit_status'],
                                'early_balance' => $data['early_balance'],
                                'apply' => $data['apply'],
                                'total_increase' => $data['total_increase'],
                                'total_sum_refer' => $data['early_balance'] + $data['apply'],
                                'total_remain' => $data['new_credit_status'] - ($data['early_balance'] + $data['apply']),
                            ]
                        );
                    } catch (\Exception $e) {
                        Log::error("Error storing summary for report_key: {$reportKeyId}, Error: " . $e->getMessage());
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