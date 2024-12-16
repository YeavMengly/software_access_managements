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
        $reports = Report::getReportSql()->get();
        $totals = $this->calculateTotals($reports);
        $this->storeSummaryReport($totals);

        if (isset($totals['code']) && is_array($totals['code'])) {
            ksort($totals['code']);
        }

        return view('layouts.table.result-total-summaries-table', compact('totals'));
    }

    public function export(Request $request)
    {
        try {
            $query = SummaryReport::query();
            $reports = $query->get();
            $resultExport = new SummariesExport($reports);
            return $resultExport->export($request);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function exportPdf(Request $request)
    {
        try {
            $query = Report::query();
            $reports = $query->get();
            $totals = $this->calculateTotals($reports);

            $html = view('layouts.pdf.summaries_pdf', compact('reports', 'totals'))->render();
            $mpdf = new \Mpdf\Mpdf([
                'format' => 'A2-L',
            ]);
            $mpdf->WriteHTML($html);

            return $mpdf->Output('របាយការណ៍សង្ខេប.pdf', 'D');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function calculateTotals($reports)
    {
        $totals = [
            'fin_law' => 0,
            'current_loan' => 0,
            'decrease' => 0,
            'new_credit_status' => 0,
            'early_balance' => 0,
            'apply' => 0,
            'total_increase' => 0,
            'code' => [],
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
            'report_key_seven' => [],
        ];

        foreach ($reports as $index => $report) {
            $totals['code']["$report->code"] = $this->calculateSumFields($report);
            $totals['fin_law'] += $report->fin_law ?? 0;
            $totals['current_loan'] += $report->current_loan ?? 0;
            $totals['decrease'] += $report->decrease ?? 0;
            $totals['new_credit_status'] += $report->new_credit_status ?? 0;
            $totals['early_balance'] += $report->early_balance ?? 0;
            $totals['apply'] += $report->apply ?? 0;
            $report1 = substr($report->report_key, 2, 1);
            $totals['total_sums']['fin_law'] += ($totals['code']["$report->code"]['fin_law'] ?? 0);
            $totals['total_sums']['current_loan'] += ($totals['code']["$report->code"]['current_loan'] ?? 0);
            $totals['total_sums']['decrease'] += ($totals['code']["$report->code"]['decrease'] ?? 0);
            $totals['total_sums']['new_credit_status'] += ($totals['code']["$report->code"]['new_credit_status'] ?? 0);
            $totals['total_sums']['early_balance'] += ($totals['code']["$report->code"]['early_balance'] ?? 0);
            $totals['total_sums']['apply'] += ($totals['code']["$report->code"]['apply'] ?? 0);
            $totals['total_sums']['total_increase'] += ($totals['code']["$report->code"]['total_increase'] ?? 0);
            $totals['total_sums']['total_sum_refer'] += ($totals['code']["$report->code"]['early_balance'] ?? 0) + ($totals['code']["$report->code"]['apply'] ?? 0);
            $totals['total_sums']['total_remain'] += ($totals['code']["$report->code"]['new_credit_status'] ?? 0) - (($totals['code']["$report->code"]['early_balance'] ?? 0) + ($totals['code']["$report->code"]['apply'] ?? 0));

            $totals['report_key']["$report1"] = [
                'fin_law' => $totals['report_key']["$report1"]['fin_law'] ?? 0,
                'current_loan' => $totals['report_key']["$report1"]['current_loan'] ?? 0,
                'decrease' => $totals['report_key']["$report1"]['decrease'] ?? 0,
                'new_credit_status' => $totals['report_key']["$report1"]['new_credit_status'] ?? 0,
                'early_balance' => $totals['report_key']["$report1"]['early_balance'] ?? 0,
                'apply' => $totals['report_key']["$report1"]['apply'] ?? 0,
                'total_increase' => $totals['report_key']["$report1"]['total_increase'] ?? 0,
                'total_sum_refer' => $totals['report_key']["$report1"]['total_sum_refer'] ?? 0,
                'total_remain' => $totals['report_key']["$report1"]['total_remain'] ?? 0,
            ];

            $totals['report_key']["$report1"]['report_key_seven']["$report->report_key"] = $this->calculateSumFields($report);
            $totals['report_key']["$report1"]['fin_law'] += $totals['report_key']["$report1"]['report_key_seven']["$report->report_key"]['fin_law'];
            $totals['report_key']["$report1"]['current_loan'] += $totals['report_key']["$report1"]['report_key_seven']["$report->report_key"]['current_loan'];
            $totals['report_key']["$report1"]['decrease'] += $totals['report_key']["$report1"]['report_key_seven']["$report->report_key"]['decrease'];
            $totals['report_key']["$report1"]['new_credit_status'] += $totals['report_key']["$report1"]['report_key_seven']["$report->report_key"]['new_credit_status'];
            $totals['report_key']["$report1"]['early_balance'] += $totals['report_key']["$report1"]['report_key_seven']["$report->report_key"]['early_balance'];
            $totals['report_key']["$report1"]['apply'] += $totals['report_key']["$report1"]['report_key_seven']["$report->report_key"]['apply'];
            $totals['report_key']["$report1"]['total_increase'] += $totals['report_key']["$report1"]['report_key_seven']["$report->report_key"]['total_increase'];
            $totals['report_key']["$report1"]['total_sum_refer'] += $totals['report_key']["$report1"]['report_key_seven']["$report->report_key"]['early_balance'] + $totals['report_key']["$report1"]['report_key_seven']["$report->report_key"]['apply'];
            $totals['report_key']["$report1"]['total_remain'] += $totals['report_key']["$report1"]['report_key_seven']["$report->report_key"]['new_credit_status']
                - ($totals['report_key']["$report1"]['report_key_seven']["$report->report_key"]['early_balance'] + $totals['report_key']["$report1"]['report_key_seven']["$report->report_key"]['apply']);
        }

        return $totals;
    }

    private function calculateSumFields($reports)
    {
        return [
            'fin_law' => ($reports->fin_law ?? 0),
            'current_loan' => ($reports->current_loan ?? 0),
            'decrease' => ($reports->decrease ?? 0),
            'new_credit_status' => ($reports->new_credit_status ?? 0),
            'early_balance' => ($reports->early_balance ?? 0),
            'apply' => ($reports->apply ?? 0),
            'total_increase' => ($reports->total_increase ?? 0)
        ];
    }

    private function storeSummaryReport($totals)
    {
        try {
            DB::transaction(function () use ($totals) {
                foreach ($totals['code'] as $code => $data) {
                    try {
                        SummaryReport::updateOrCreate(
                            ['program' => $code->code],
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
                        Log::error("Error storing summary for code: {$code->code}, Error: " . $e->getMessage());
                    }
                }
            });
        } catch (\Exception $e) {
            Log::error('Transaction failed: ' . $e->getMessage());
        }
    }
}
