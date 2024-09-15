<?php

namespace App\Http\Controllers\Result\ResultSuccess;

use App\Http\Controllers\Controller;
use App\Models\Code\Report;
use Illuminate\Http\Request;

class CostPerformController extends Controller
{
    public function index(Request $request)
    {
        // Fetch reports (adjust the query as needed)
        $reports = Report::all(); // Example, you can use specific filtering here

        // Calculate the totals
        $totals = $this->calculateTotals($reports);

        // Store the totals into the database
        $this->storeSummaryReport($totals);

        // Get sort order from request, default to ascending ('asc')
        $sortOrder = $request->get('sort', 'asc');

        // Sort totals by codeId based on the sort order
        if (isset($totals['code']) && is_array($totals['code'])) {
            ksort($totals['code']); // Sort by key (codeId) in ascending order
        }

        return view('layouts.table.result-success-table.result-cost-perform', compact('totals', 'sortOrder'));
    }

    private function calculateTotals($reports)
    {
        // Initialize the totals array with all fields set to 0
        $totals = [
            'fin_law' => 0,
            'current_loan' => 0,
            'apply' => 0,
            'code' => [],
        ];

       
        foreach ($reports as $report) {
            $totals['fin_law'] += $report->fin_law;
            $totals['current_loan'] += $report->current_loan;
            $totals['apply'] += $report->apply;
        }

        // Group reports by code
        $groupedByCode = $reports->groupBy(function ($report) {
            return $report->subAccountKey->accountKey->key->code ?? 'Unknown';
        });

        foreach ($groupedByCode as $codeId => $reportsByCode) {
            $totals['code'][$codeId] = $this->calculateSumFields($reportsByCode);
            $totals['code'][$codeId]['name'] = $reportsByCode->first()->subAccountKey->accountKey->key->name ?? 'Unknown';
        }

        return $totals;
    }

    private function calculateSumFields($reports)
    {
        $sumFields = [
            'fin_law' => 0,
            'current_loan' => 0,
            'apply' => 0,
        ];

        foreach ($reports as $report) {
            foreach ($sumFields as $key => &$value) {
                $value += $report->$key;
            }

            // Calculate the 'total_increase' as the sum of 'internal_increase', 'unexpected_increase', and 'additional_increase'
            $sumFields['total_increase'] = $sumFields['internal_increase'] + $sumFields['unexpected_increase'] + $sumFields['additional_increase'];
        }

        return $sumFields;
    }
}
