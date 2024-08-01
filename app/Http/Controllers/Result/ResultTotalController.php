<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use App\Models\Code\Report;
use Illuminate\Http\Request;

class ResultTotalController extends Controller
{

    public int $earlyBalance = 10000;
    public int $apply = 0;
    
    public function index()
    {
        $reports = Report::all();

        // Calculate the totals
        $totals = [
            'internal_increase' => $reports->sum('internal_increase'),
            'unexpected_increase' => $reports->sum('unexpected_increase'),
            'additional_increase' => $reports->sum('additional_increase'),
            'decrease' => $reports->sum('decrease'),
            'total_increase' => $reports->sum(function ($report) {
                return $report->internal_increase + $report->unexpected_increase + $report->additional_increase;
            }),
            'total_internal_unexpected_additional' => $reports->sum(function ($report) {
                return $report->current_loan + ($report->internal_increase + $report->unexpected_increase + $report->additional_increase) - $report->decrease - $report->editorial;
            }),

            'deadline_balance' => $reports->sum(function ($report) {
                return $report->earlyBalance + $report->apply;
            }),

        ];

        return view('layouts.table.result-total-table', [
            'reports' => $reports,
            'totals' => $totals,
        ]);
    }
}
