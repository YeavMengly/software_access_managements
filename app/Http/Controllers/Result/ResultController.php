<?php

namespace App\Http\Controllers\Result;

use App\Exports\Results\ResultExport;
use App\Http\Controllers\Controller;
use App\Models\Certificates\Certificate;
use App\Models\Certificates\CertificateData;
use App\Models\Code\Loans;
use App\Models\Code\Report;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        // Initialize query builders for both Report and Loans models
        $reportQuery = Report::query();
        $loanQuery = Loans::query();

        // Apply filters to both Report and Loans based on request input
        $this->applyFilters($reportQuery, $request);
        $this->applyFilters($loanQuery, $request);

        // Check if export is requested
        if ($request->has('export')) {
            // Merge Report and Loans results for export
            $combinedResults = $reportQuery->get()->merge($loanQuery->get());

            // Return Excel file download with the combined results
            return Excel::download(new ResultExport($combinedResults), 'results.xlsx');
        }

        // Retrieve filtered results for both Report and Loans
        $reports = $reportQuery->get();
        $loans = $loanQuery->get();

        // Calculate totals for both Report and Loans results
        $totals = $this->calculateTotals($reports, $loans);

        // Return the view with results and totals for both Report and Loans
        return view('layouts.table.result', compact('totals', 'reports', 'loans'));
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

            // Log the count of retrieved results for debugging
            Log::info('Exported Report Results Count: ' . $results->count());

            // Check if any results were retrieved
            if ($results->isEmpty()) {
                Log::warning('No results found for export.');
                return response()->json(['error' => 'No results found to export.'], 404);
            }

            // Create an instance of ResultExport and call the export method
            $resultExport = new ResultExport($results);
            return $resultExport->export($request);
        } catch (\Exception $e) {
            Log::error('Export Error: ' . $e->getMessage());
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
            // $totals = $this->calculateTotals($reports);

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
                $reports = CertificateData::whereBetween('created_at', [$startDate, $endDate])->get(['report_key']);
                $reports = !empty($reports) ? $reports->toArray() : [];
                $query->whereIn('id', $reports);
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
                $reports = CertificateData::where('created_at', '>=', $startDate)->get(['report_key']);
                $reports = !empty($reports) ? $reports->toArray() : [];
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


        // Apply code filters only for queries that can handle them
        if ($query->getModel() instanceof Loans) {
            // Apply filters that are relevant for the Loans model
            // Adjust this part if loans have relevant fields to filter
        } elseif ($query->getModel() instanceof Report) {
            // Apply filters specific to Report model
            $this->applyCodeFilter($query, $codeId, 'code', 2, 'subAccountKey.accountKey.key');
            $this->applyCodeFilter($query, $accountKeyId, 'account_key', 4, 'subAccountKey.accountKey');
            $this->applyCodeFilter($query, $subAccountKeyId, 'sub_account_key', 5, 'subAccountKey');
            $this->applyCodeFilter($query, $reportKey, 'report_key', 7);
        }

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
            $loan = $result->loans;

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
            $totals['fin_law'] += $result->fin_law ?? 0;
            $totals['current_loan'] += $result->current_loan ?? 0;


            if (!empty($loan)) {
                // Aggregate values
                $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['fin_law'] += $result->fin_law;
                $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['current_loan'] += $result->current_loan;
                $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['internal_increase'] += $loan->internal_increase;
                $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['unexpected_increase'] += $loan->unexpected_increase;
                $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['additional_increase'] += $loan->additional_increase;
                $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['decrease'] += $loan->decrease;
                $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['editorial'] += $loan->editorial;
                $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['new_credit_status'] += $result->new_credit_status;
                $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['early_balance'] += $result->early_balance;
                $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['apply'] += $result->apply;
                $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['deadline_balance'] += $result->deadline_balance;
                $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['credit'] += $result->credit;
                $totals['internal_increase'] += $loan->internal_increase ?? 0;
                $totals['unexpected_increase'] += $loan->unexpected_increase ?? 0;
                $totals['additional_increase'] += $loan->additional_increase ?? 0;
                $totals['decrease'] += $loan->decrease ?? 0;
                $totals['editorial'] += $loan->editorial ?? 0;

                $totalIncrease = $loan->internal_increase + $loan->unexpected_increase + $loan->additional_increase;
                $totals['total_increase'] += $totalIncrease;
            }
            $totals['new_credit_status'] += $result->new_credit_status ?? 0;
            $totals['early_balance'] += $result->early_balance ?? 0;
            $totals['apply'] += $result->apply ?? 0;
            $totals['deadline_balance'] += $result->deadline_balance ?? 0;
            $totals['credit'] += $result->credit ?? 0;
        }

        $totals['law_average'] = $totals['fin_law'] > 0 || $totals['fin_law'] > 0  ? ($totals['deadline_balance'] / $totals['fin_law']) * 100 : 0;
        $totals['law_correction'] =   $totals['new_credit_status'] > 0 ||  $totals['new_credit_status'] ? ($totals['deadline_balance'] / $totals['new_credit_status']) * 100 : 0;

        // Group reports and loans by code
        $groupedByCode = $reports->groupBy(function ($loan) {
            return $loan->subAccountKey->accountKey->key->code ?? 'Unknown';
        });

        // Continue grouping by accountKey, subAccountKey, and reportKey for both reports and loans
        foreach ($groupedByCode as $codeId => $loansByCode) {
            $totals['code'][$codeId] = $this->calculateSumFields($loansByCode);
            $totals['code'][$codeId]['name'] = $loansByCode->first()->subAccountKey->accountKey->key->name ?? 'Unknown';

            $groupedByAccountKey = $loansByCode->groupBy(function ($loan) {
                return $loan->subAccountKey->accountKey->account_key ?? 'Unknown';
            });

            foreach ($groupedByAccountKey as $accountKeyId => $loansByAccountKey) {
                $totals['accountKey'][$codeId][$accountKeyId] = $this->calculateSumFields($loansByAccountKey);
                $totals['accountKey'][$codeId][$accountKeyId]['name_account_key'] = $loansByAccountKey->first()->subAccountKey->accountKey->name_account_key ?? 'Unknown';

                $groupedBySubAccountKey = $loansByAccountKey->groupBy(function ($loan) {
                    return $loan->subAccountKey->sub_account_key ?? 'Unknown';
                });

                foreach ($groupedBySubAccountKey as $subAccountKeyId => $loansBySubAccountKey) {
                    $totals['subAccountKey'][$codeId][$accountKeyId][$subAccountKeyId] = $this->calculateSumFields($loansBySubAccountKey);
                    $totals['subAccountKey'][$codeId][$accountKeyId][$subAccountKeyId]['name_sub_account_key'] = $loansBySubAccountKey->first()->subAccountKey->name_sub_account_key ?? 'Unknown';

                    $groupedByReportKey = $loansBySubAccountKey->groupBy(function ($loan) {
                        return $loan->report_key;
                    });

                    foreach ($groupedByReportKey as $reportKeyId => $loansByReportKey) {
                        $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId] = $this->calculateSumFields($loansByReportKey);
                        $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['name_report_key'] = $loansByReportKey->first()->name_report_key ?? 'Unknown';
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
            $loan = $report->loans;
            $sumFields['fin_law'] += $report->fin_law;
            $sumFields['current_loan'] += $report->current_loan;

            if (!empty($loan)) {
                $sumFields['internal_increase'] += $loan->internal_increase;
                $sumFields['unexpected_increase'] += $loan->unexpected_increase;
                $sumFields['additional_increase'] += $loan->additional_increase;
                $sumFields['decrease'] += $loan->decrease;
                $sumFields['editorial'] += $loan->editorial;
            }
            $sumFields['new_credit_status'] += $report->new_credit_status;
            $sumFields['early_balance'] += $report->early_balance;
            $sumFields['apply'] += $report->apply;
            $sumFields['deadline_balance'] += $report->deadline_balance;
            $sumFields['credit'] += $report->credit;
        }

        // Calculate the 'total_increase' as the sum of 'internal_increase', 'unexpected_increase', and 'additional_increase'
        $sumFields['total_increase'] = $sumFields['internal_increase'] + $sumFields['unexpected_increase'] + $sumFields['additional_increase'];

        $sumFields['law_average'] = ($sumFields['fin_law'] < 0 || $sumFields['deadline_balance'] > 0) ?
            ($sumFields['deadline_balance'] / $sumFields['fin_law']) * 100 : null;

        $sumFields['law_correction'] = ($sumFields['new_credit_status'] < 0 || $sumFields['deadline_balance'] > 0) ?
            ($sumFields['deadline_balance'] / $sumFields['new_credit_status']) * 100 : null;

        return $sumFields;
    }
}
