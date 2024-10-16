<?php

namespace App\Http\Controllers\Result;

use App\Exports\Results\ResultExport;
use App\Http\Controllers\Controller;
use App\Models\Code\Report;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        // Initialize query builder for Report model
        $query = Report::query();

        // Apply filters based on request input
        $this->applyFilters($query, $request);

        // Check if export is requested
        if ($request->has('export')) {
            // Return Excel file download
            return Excel::download(new ResultExport($query->get()), 'results.xlsx');
        }

        // Retrieve filtered results
        $results = $query->get();

        // Calculate totals for the results
        $totals = $this->calculateTotals($results);

        // Return the view with results and totals
        return view('layouts.table.result', compact('totals', 'results'));
    }


    public function export(Request $request)
    {
        try {
            // Initialize query builder for Report model
            $query = Report::query();
    
            // Apply filters
            $this->applyFilters($query, $request);
    
            // Retrieve the filtered data
            $results = $query->get();
    
            // Create an instance of ResultExport and call the export method
            $resultExport = new ResultExport($results);
            return $resultExport->export($request);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function exportPdf(Request $request)
    {
        try {
            // Initialize query builder for Report model
            $query = Report::query();

            // Apply filters
            $this->applyFilters($query, $request);

            // Get data
            $reports = $query->get();
            $totals = $this->calculateTotals($reports);

            // Build the HTML content
            $html = view('layouts.pdf.result_pdf', compact('reports', 'totals'))->render();

            // Generate PDF using mPDF
            $mpdf = new \Mpdf\Mpdf(['format' => 'A2-L']);

            // Write the HTML content to the PDF
            $mpdf->WriteHTML($html);

            // Download PDF
            return $mpdf->Output('របាយការណ៍ធានាចំណាយថវិការ.pdf', 'D');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function applyDateFilter($query, $startDate, $endDate)
    {
        // Apply date range filter
        if ($startDate && $endDate) {
            try {
                $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay()->toDateTimeString();
                $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay()->toDateTimeString();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } catch (\Exception $e) {
                // Handle invalid date format error
                Log::error('Invalid date format: ' . $e->getMessage());
                return redirect()->back()->withErrors(['date' => 'Invalid date format. Please use YYYY-MM-DD format.']);
            }
        }
        // Apply single start date filter
        elseif ($startDate) {
            try {
                $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay()->toDateTimeString();
                $query->where('created_at', '>=', $startDate);
            } catch (\Exception $e) {
                // Handle invalid date format error
                Log::error('Invalid date format: ' . $e->getMessage());
                return redirect()->back()->withErrors(['date' => 'Invalid date format. Please use YYYY-MM-DD format.']);
            }
        }
    }

    private function applyFilters($query, Request $request)
    {
        $codeId = $request->input('code_id');
        $accountKeyId = $request->input('account_key_id');
        $subAccountKeyId = $request->input('sub_account_key_id');
        $reportKey = $request->input('report_key');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $this->applyCodeFilter($query, $codeId, 'code', 2, 'subAccountKey.accountKey.key');
        $this->applyCodeFilter($query, $accountKeyId, 'account_key', 4, 'subAccountKey.accountKey');
        $this->applyCodeFilter($query, $subAccountKeyId, 'sub_account_key', 5, 'subAccountKey');
        $this->applyCodeFilter($query, $reportKey, 'report_key', 7);

        // Apply date filter based on provided inputs
        $this->applyDateFilter($query, $startDate, $endDate);
    }

    private function applyCodeFilter($query, $input, $column, $length, $relation = null)
    {
        // Check first-digit
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
        // Initialize the totals array 
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
            'reportKey' => [],
        ];

        foreach ($reports as $result) {
            // Grouping the results for totals
            $codeId = $result->code_id;
            $accountKeyId = $result->account_key_id;
            $subAccountKeyId = $result->sub_account_key_id;
            $reportKeyId = $result->report_key;

            // Initialize arrays if not already set
            if (!isset($totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId])) {
                $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId] = [];
            }

            // Accumulate totals for each report key
            if (!isset($totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId])) {
                $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId] = [
                    'name_report_key' => $result->name_report_key,
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
                ];
            }

            // Aggregate values
            $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['fin_law'] += $result->fin_law;
            $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['current_loan'] += $result->current_loan;
            $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['internal_increase'] += $result->internal_increase;
            $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['unexpected_increase'] += $result->unexpected_increase;
            $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['additional_increase'] += $result->additional_increase;
            $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['decrease'] += $result->decrease;
            $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['editorial'] += $result->editorial;
            $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['new_credit_status'] += $result->new_credit_status;
            $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['early_balance'] += $result->early_balance;
            $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['apply'] += $result->apply;
            $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['deadline_balance'] += $result->deadline_balance;
            $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['credit'] += $result->credit;
            $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['law_average'] = $result->law_average;
            $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['law_correction'] += $result->law_correction;
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
            $totals['law_average'] = $totals['law_average'] ? ($totals['deadline_balance'] / $totals['fin_law']) * 100 : 0;
            $totals['law_correction'] =  $totals['law_correction'] ? ($totals['deadline_balance'] / $totals['new_credit_status']) * 100 : 0;
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

                    // Group by reportKey within each subAccountKey
                    $groupedByReportKey = $reportsBySubAccountKey->groupBy(function ($report) {
                        return $report->report_key;
                    });

                    foreach ($groupedByReportKey as $reportKeyId => $reportsByReportKey) {
                        $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId] = $this->calculateSumFields($reportsByReportKey);
                        $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['name_report_key'] = $reportsByReportKey->first()->name_report_key ?? 'Unknown';
                    }
                }
            }
        }

        return $totals;
    }

    private function calculateSumFields($reports)
    {
        $sumFields = [
            'fin_law' => 0,
            'current_loan' => 0,
            'internal_increase' => 0,
            'unexpected_increase' => 0,
            'additional_increase' => 0,
            'total_increase' => 0,
            'decrease' => 0,
            'editorial' => 0,
            'new_credit_status' => 0,
            'early_balance' => 0,
            'apply' => 0,
            'deadline_balance' => 0,
            'credit' => 0,
            'law_average' => 0,
            'law_correction' => 0,

        ];

        foreach ($reports as $report) {
            $sumFields['fin_law'] += $report->fin_law;
            $sumFields['current_loan'] += $report->current_loan;
            $sumFields['internal_increase'] += $report->internal_increase;
            $sumFields['unexpected_increase'] += $report->unexpected_increase;
            $sumFields['additional_increase'] += $report->additional_increase;
            $sumFields['decrease'] += $report->decrease;
            $sumFields['editorial'] += $report->editorial;
            $sumFields['new_credit_status'] += $report->new_credit_status;
            $sumFields['early_balance'] += $report->early_balance;
            $sumFields['apply'] += $report->apply;
            $sumFields['deadline_balance'] += $report->deadline_balance;
            $sumFields['credit'] += $report->credit;

            $sumFields['law_average'] = ($sumFields['fin_law'] > 0 && $sumFields['deadline_balance'] > 0) ?
                ($sumFields['deadline_balance'] / $sumFields['fin_law']) * 100 : null;

            $sumFields['law_correction'] = ($sumFields['new_credit_status'] > 0 && $sumFields['deadline_balance'] > 0) ?
                ($sumFields['deadline_balance'] / $sumFields['new_credit_status']) * 100 : null;


            // Calculate the 'total_increase' as the sum of 'internal_increase', 'unexpected_increase', and 'additional_increase'
            $sumFields['total_increase'] = $sumFields['internal_increase'] + $sumFields['unexpected_increase'] + $sumFields['additional_increase'];
        }

        return $sumFields;
    }
}
