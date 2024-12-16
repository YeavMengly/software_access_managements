<?php

namespace App\Http\Controllers\Result\ResultSuccess;

use App\Http\Controllers\Controller;
use App\Models\Code\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CostPerformController extends Controller
{
    public function index(Request $request)
    {
        $reports = Report::with(['subAccountKey.accountKey.key'])->get();
        $totals = $this->calculateTotals($reports);
        $this->storeSummaryReport($totals);
        $sortOrder = $request->get('sort', 'asc');

        if (isset($totals['code']) && is_array($totals['code'])) {
            if ($sortOrder === 'asc') {
                ksort($totals['code']);
            } else {
                krsort($totals['code']);
            }
        }

        return view('layouts.table.result-success-table.result-cost-perform', compact('totals', 'sortOrder', 'reports'));
    }

    private function calculateTotals($reports)
    {
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

        $groupedByCode = $reports->groupBy(function ($report) {
            return optional($report->subAccountKey->accountKey->key)->code ?? 'Unknown';
        });

        foreach ($groupedByCode as $codeId => $reportsByCode) {
            $totals['code'][$codeId] = $this->calculateSumFields($reportsByCode);
            $totals['code'][$codeId]['name'] = optional($reportsByCode->first()->subAccountKey->accountKey->key)->name ?? 'Unknown';
        }
        return $totals;
    }

    private function calculateSumFields($reports)
    {
        $sumFields = [
            'fin_law' => 0,
            'current_loan' => 0,
            'apply' => 0,
            'total_increase' => 0, 
        ];

        foreach ($reports as $report) {
            $sumFields['fin_law'] += $report->fin_law;
            $sumFields['current_loan'] += $report->current_loan;
            $sumFields['apply'] += $report->apply;

            $sumFields['total_increase'] += $report->internal_increase + $report->unexpected_increase + $report->additional_increase;
        }

        return $sumFields;
    }
}
