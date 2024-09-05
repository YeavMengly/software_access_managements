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

        // Date filtering with error handling
        // $this->applyDateFilter($query, $request->date('date'));

        // Apply filters
        $this->applyFilters($query, $request);

        // $reports = $query->get();

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
        $query = Report::query();

        // Apply filters
        // $this->applyFilters($query, $request);
        // Apply filters based on the search form inputs
        if ($request->filled('code_id')) {
            $query->where('code_id', 'LIKE', $request->input('code_id') . '%');
        }
        if ($request->filled('account_key_id')) {
            $query->where('account_key_id', 'LIKE', $request->input('account_key_id') . '%');
        }
        if ($request->filled('sub_account_key_id')) {
            $query->where('sub_account_key_id', 'LIKE', $request->input('sub_account_key_id') . '%');
        }
        if ($request->filled('report_key')) {
            $query->where('report_key', 'LIKE', $request->input('report_key') . '%');
        }
        if ($request->filled('date')) {
            $query->whereDate('created_at', '=', $request->input('date')); // Use the correct column name
        }

        $results = $query->get();

        // Export data
        return Excel::download(new ResultExport($query->get()), 'reports.xlsx');
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

    private function calculateTotals($reports)
    {
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
            'total_balance' => 0,
            'sub_account_amount' => 0, // Total for subAccountKey amounts
            'account_amount' => 0, // Total for accountKey amounts
            'fin_law_by_code' => [] // Total of fin_law grouped by code
        ];

        // Group reports by code
        $groupedReports = $reports->groupBy('code');

        foreach ($groupedReports as $code => $group) {
            $finLawTotal = $group->sum('fin_law');
            $totals['fin_law_by_code'][$code] = $finLawTotal;
        }

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
            $totals['total_balance'] += ($totalIncrease - $report->decrease);

            // Sum subAccountKey amounts
            if ($report->subAccountKey) {
                $totals['sub_account_amount'] += $report->subAccountKey->amount ?? 0;
            }

            // Sum accountKey amounts
            if ($report->subAccountKey && $report->subAccountKey->accountKey) {
                $totals['account_amount'] += $report->subAccountKey->accountKey->amount ?? 0;
            }
        }

        return $totals;
    }
}
