<?php

namespace App\Exports\Results;

use App\Models\Code\Report;
use App\Models\Report\ReportKeyTotal;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SummariesExport
{
    protected $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    public function export(Request $request)
    {
        // Load the existing Excel template
        $templatePath = public_path('summaries_template.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        
        $row = 13;
        // ==============================================================

        $this->results = Report::with('subAccountKey.accountKey.key')->get();

        // Group reports by code
        $groupedByCode = $this->results->groupBy(function ($result) {
            return $result->subAccountKey->accountKey->key->code ?? 'Unknown';
        });
        
        // Initialize total sums
        $totalSums = [
            'fin_law' => 0,
            'current_loan' => 0,
            'total_increase' => 0,
            'decrease' => 0,
            'new_credit_status' => 0,
            'early_balance' => 0,
            'apply' => 0,
            'total_sum_refer' => 0,
            'total_remain' => 0,
        ];

        foreach ($groupedByCode as $codeId => $reportsByCode) {
           
            $totalsByCode = array_fill_keys(array_keys($totalSums), 0);
        
            $reportKeys = [];

            foreach ($reportsByCode as $report) {
                $totalsByCode['fin_law'] += $report->fin_law;
                $totalsByCode['current_loan'] += $report->current_loan;
                $totalsByCode['total_increase'] += $report->total_increase;
                $totalsByCode['decrease'] += $report->decrease;
                $totalsByCode['new_credit_status'] += $report->new_credit_status;
                $totalsByCode['early_balance'] += $report->early_balance;
                $totalsByCode['apply'] += $report->apply;
                
                if (!in_array($report->report_key, $reportKeys)) {
                    $reportKeys[] = $report->report_key; 
                }
            }
        
            // Update total sums across all codes
            foreach ($totalsByCode as $key => $value) {
                $totalSums[$key] += $value;
            }
        
            // Populate the Excel sheet for the current codeId
            $sheet->setCellValue('A' . $row, $codeId);
            foreach ($totalsByCode as $key => $value) {
                $sheet->setCellValue(chr(66 + array_search($key, array_keys($totalsByCode))) . $row, number_format($value, 0, ' ', ' '));
            }
        
            // Average calculations
            $avgEarlyBalance = $totalsByCode['new_credit_status'] > 0 
                ? ($totalsByCode['early_balance'] / $totalsByCode['new_credit_status']) * 100 
                : 0;
            
            $avgApply = $totalsByCode['new_credit_status'] > 0 
                ? ($totalsByCode['apply'] / $totalsByCode['new_credit_status']) * 100 
                : 0;
        
            // Sum refer and averages
            $sumRefer = $totalsByCode['early_balance'] + $totalsByCode['apply'];
            $avgSumRefer = $totalsByCode['new_credit_status'] > 0 
                ? ($sumRefer / $totalsByCode['new_credit_status']) * 100 
                : 0;
        
            // Average remain
            $remain = $totalsByCode['new_credit_status'] - $sumRefer;
            $avgRemain = $totalsByCode['new_credit_status'] > 0 
                ? ($remain / $totalsByCode['new_credit_status']) * 100 
                : 0;
        
            // Write to the sheet
            $sheet->setCellValue('G' . $row, number_format($totalsByCode['early_balance'], 0, ' ', ' '));
            $sheet->setCellValue('H' . $row, number_format($avgEarlyBalance, 2, '.', ' ') . '%');
            $sheet->setCellValue('I' . $row, number_format($totalsByCode['apply'], 0, ' ', ' '));
            $sheet->setCellValue('J' . $row, number_format($avgApply, 2, '.', ' ') . '%');
            $sheet->setCellValue('K' . $row, number_format($sumRefer, 0, ' ', ' '));
            $sheet->setCellValue('L' . $row, number_format($avgSumRefer, 2, '.', ' ') . '%');
            $sheet->setCellValue('M' . $row, number_format($remain, 0, ' ', ' '));
            $sheet->setCellValue('N' . $row, number_format($avgRemain, 2, '.', ' ') . '%');

            $row++;
        }
        
        // Insert total sums at the bottom of the report
        $sheet->setCellValue("A{$row}", 'សរុបជំពូក');  // Total label
        foreach ($totalSums as $key => $value) {
            $sheet->setCellValue(chr(66 + array_search($key, array_keys($totalSums))) . $row, number_format($value, 0, ' ', ' '));
        }
        
        // Calculate overall averages
        $overallAvgEarlyBalance = $totalSums['new_credit_status'] > 0 
            ? ($totalSums['early_balance'] / $totalSums['new_credit_status']) * 100 
            : 0;
        
        $overallAvgApply = $totalSums['new_credit_status'] > 0 
            ? ($totalSums['apply'] / $totalSums['new_credit_status']) * 100 
            : 0;
        
        $overallSumRefer = $totalSums['early_balance'] + $totalSums['apply'];
        $overallAvgSumRefer = $totalSums['new_credit_status'] > 0 
            ? ($overallSumRefer / $totalSums['new_credit_status']) * 100 
            : 0;
        
        $overallRemain = $totalSums['new_credit_status'] - $overallSumRefer;
        $overallAvgRemain = $totalSums['new_credit_status'] > 0 
            ? ($overallRemain / $totalSums['new_credit_status']) * 100 
            : 0;
        
        // Write overall averages to the sheet
        $sheet->setCellValue("G{$row}", number_format($totalSums['early_balance'], 0, ' ', ' '));
        $sheet->setCellValue("H{$row}", number_format($overallAvgEarlyBalance, 2, '.', ' ') . '%');
        $sheet->setCellValue("I{$row}", number_format($totalSums['apply'], 0, ' ', ' '));
        $sheet->setCellValue("J{$row}", number_format($overallAvgApply, 2, '.', ' ') . '%');
        $sheet->setCellValue("K{$row}", number_format($overallSumRefer, 0, ' ', ' '));
        $sheet->setCellValue("L{$row}", number_format($overallAvgSumRefer, 2, '.', ' ') . '%');
        $sheet->setCellValue("M{$row}", number_format($overallRemain, 0, ' ', ' '));
        $sheet->setCellValue("N{$row}", number_format($overallAvgRemain, 2, '.', ' ') . '%');
        
        // ==============================================================

        // Apply styles for the totals row
        $totalsStyleArray = [
            // 'font' => [
            //     'bold' => true,
            //     'size' => 12,
            // ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'B5F556',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle("A{$row}:N{$row}")->applyFromArray($totalsStyleArray);

        // Save the modified spreadsheet as a new file or download directly
        $fileName = 'summaries_export.xlsx';
        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ]);
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
