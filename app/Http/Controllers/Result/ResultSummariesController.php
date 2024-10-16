<?php

namespace App\Http\Controllers\Result;

use App\Exports\Results\SummariesExport;
use App\Http\Controllers\Controller;
use App\Models\Code\Report;
use App\Models\Loans\SummaryReport;
use App\Models\Report\ReportKeyTotal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResultSummariesController extends Controller
{
    public function index()
    {
        // Fetch reports (Adjust the query as needed)
        $reports = Report::all();

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

    public function export(Request $request)
    {
        try {
            // Initialize query builder for Report model
            $query = SummaryReport::query();

            // Apply filters
            // $this->applyFilters($query, $request);

            // Retrieve the filtered data
            $reports = $query->get();

            // Create an instance of ResultExport and call the export method
            $resultExport = new SummariesExport($reports);
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

            // Get data
            $reports = $query->get();
            $totals = $this->calculateTotals($reports);

            // Build the HTML content
            $html = view('layouts.pdf.summaries_pdf', compact('reports', 'totals'))->render();

            // Configure mPDF with Khmer font and landscape mode
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'A2-L',
            ]);

            // Write the HTML content to the PDF
            $mpdf->WriteHTML($html);

            // Output PDF to download
            return $mpdf->Output('របាយការណ៍សង្ខេប.pdf', 'D');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
            'code' => [],
            'total_sums' => [ // New section to store column sums
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

        // Group reports by code
        $groupedByCode = $reports->groupBy(function ($report) {
            return $report->subAccountKey->accountKey->key->code ?? 'Unknown';
        });

        foreach ($groupedByCode as $codeId => $reportsByCode) {
            $totals['code'][$codeId] = $this->calculateSumFields($reportsByCode);

            // Update the total sums
            $totals['total_sums']['fin_law'] += $totals['code'][$codeId]['fin_law'];
            $totals['total_sums']['current_loan'] += $totals['code'][$codeId]['current_loan'];
            $totals['total_sums']['decrease'] += $totals['code'][$codeId]['decrease'];
            $totals['total_sums']['new_credit_status'] += $totals['code'][$codeId]['new_credit_status'];
            $totals['total_sums']['early_balance'] += $totals['code'][$codeId]['early_balance'];
            $totals['total_sums']['apply'] += $totals['code'][$codeId]['apply'];
            $totals['total_sums']['total_increase'] += $totals['code'][$codeId]['total_increase'];
            $totals['total_sums']['total_sum_refer'] += $totals['code'][$codeId]['early_balance'] + $totals['code'][$codeId]['apply'];
            $totals['total_sums']['total_remain'] += $totals['code'][$codeId]['new_credit_status'] - ($totals['code'][$codeId]['early_balance'] + $totals['code'][$codeId]['apply']);
        }

        // Group reports by the first three digits of report_key
        $groupedByReportKeyThreePrefix = $reports->groupBy(function ($report) {
            return substr($report->report_key, 0, 3); // Extract first 3 digits of report_key
        });

        // Calculate totals for the three-digit grouping
        foreach ($groupedByReportKeyThreePrefix as $prefix => $reportsByPrefix) {
            // Initialize group totals for the prefix
            $totals['report_key'][$prefix] = $this->calculateSumFields($reportsByPrefix);

            // Call this function for store 
            $this->updateReportKeyTotal($prefix, $totals);
        }

        $totals['report_key'] = collect($totals['report_key'])->sortKeys();

        $groupedByReportKeySevenPrefix = $reports->groupBy(function ($report) {
            return substr($report->report_key, 0, 7); // Extract first 7 digits of report_key
        });

        // Calculate totals for the seven-digit grouping
        foreach ($groupedByReportKeySevenPrefix as $prefix => $reportsByPrefix) {

            // Initialize group totals for the prefix
            $totals['report_key_seven'][$prefix] = $this->calculateSumFields($reportsByPrefix);

            // Update the total sums using the seven-digit prefix
            $totals['total_sums']['fin_law'] += $totals['report_key_seven'][$prefix]['fin_law'];
            $totals['total_sums']['current_loan'] += $totals['report_key_seven'][$prefix]['current_loan'];
            $totals['total_sums']['decrease'] += $totals['report_key_seven'][$prefix]['decrease'];
            $totals['total_sums']['new_credit_status'] += $totals['report_key_seven'][$prefix]['new_credit_status'];
            $totals['total_sums']['early_balance'] += $totals['report_key_seven'][$prefix]['early_balance'];
            $totals['total_sums']['apply'] += $totals['report_key_seven'][$prefix]['apply'];
            $totals['total_sums']['total_increase'] += $totals['report_key_seven'][$prefix]['total_increase'];
            $totals['total_sums']['total_sum_refer'] += $totals['report_key_seven'][$prefix]['early_balance'] + $totals['report_key_seven'][$prefix]['apply'];
            $totals['total_sums']['total_remain'] += $totals['report_key_seven'][$prefix]['new_credit_status'] - ($totals['report_key_seven'][$prefix]['early_balance'] + $totals['report_key_seven'][$prefix]['apply']);
        }

        $totals['report_key_seven'] = collect($totals['report_key_seven'])->sortKeys();

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

    private function updateReportKeyTotal($prefix, $totals)
    {
        try {
            // Attempt to update or create the ReportKeyTotal entry
            ReportKeyTotal::updateOrCreate(
                ['report_key_prefix' => $prefix], // Unique prefix
                [
                    'fin_law' => $totals['report_key'][$prefix]['fin_law'],
                    'current_loan' => $totals['report_key'][$prefix]['current_loan'],
                    'decrease' => $totals['report_key'][$prefix]['decrease'],
                    'new_credit_status' => $totals['report_key'][$prefix]['new_credit_status'],
                    'early_balance' => $totals['report_key'][$prefix]['early_balance'],
                    'apply' => $totals['report_key'][$prefix]['apply'],
                    'total_increase' => $totals['report_key'][$prefix]['total_increase'],
                    'total_sum_refer' => $totals['report_key'][$prefix]['early_balance'] + $totals['report_key'][$prefix]['apply'],
                    'total_remain' => $totals['report_key'][$prefix]['new_credit_status'] - ($totals['report_key'][$prefix]['early_balance'] + $totals['report_key'][$prefix]['apply']),
                ]
            );
        } catch (\Exception $e) {
            // Handle the exception and return a suitable response or log the error
            Log::error('Failed to update ReportKeyTotal for prefix: ' . $prefix, ['error' => $e->getMessage()]);

            // Optionally, you can throw an HTTP exception or return a response
            return response()->json([
                'message' => 'Failed to update report key total.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
