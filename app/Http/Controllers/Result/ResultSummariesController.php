<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use App\Models\Code\Report;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class ResultSummariesController extends Controller
{
    //
    public function index()
    {

        // Fetch reports (Adjust the query as needed)
        $reports = Report::all(); // Example, you can use specific filtering here

        // Calculate the totals
        $totals = $this->calculateTotals($reports);

        return view('layouts.table.result-total-summaries-table', compact('totals'));
    }

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

            // Group by accountKey within each codeId
            $groupedByAccountKey = $reportsByCode->groupBy(function ($report) {
                return $report->subAccountKey->accountKey->account_key ?? 'Unknown';
            });

            foreach ($groupedByAccountKey as $accountKeyId => $reportsByAccountKey) {
                $totals['accountKey'][$codeId][$accountKeyId] = $this->calculateSumFields($reportsByAccountKey);

                // Group by subAccountKey within each accountKey
                $groupedBySubAccountKey = $reportsByAccountKey->groupBy(function ($report) {
                    return $report->subAccountKey->sub_account_key ?? 'Unknown';
                });

                foreach ($groupedBySubAccountKey as $subAccountKeyId => $reportsBySubAccountKey) {
                    $totals['subAccountKey'][$codeId][$accountKeyId][$subAccountKeyId] = $this->calculateSumFields($reportsBySubAccountKey);
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
            'total_increase' => $reports-> sum('total_increase')
        ];
    }
}
