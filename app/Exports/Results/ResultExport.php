<?php

namespace App\Exports\Results;

use App\Models\Result; // Adjust according to your model namespace
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Http\Request;

class ResultExport
{
    protected $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    public function export(Request $request)
    {
        // Load the existing Excel template
        $templatePath = public_path('result_export_template.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        $row = 14; // Start from row 14

        // Group reports by code
        $groupedByCode = $this->results->groupBy(function ($result) {
            return $result->subAccountKey->accountKey->key->code ?? 'Unknown';
        });

        foreach ($groupedByCode as $codeId => $reportsByCode) {
            $firstCode = true;

            $codeName = $reportsByCode->first()->subAccountKey->accountKey->key->name ?? 'Unknown';

            $codeTotals = [
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
                'law_average' => 0,  // Calculated later
                'law_correction' => 0, // Calculated later
            ];

            $sheet->getStyle('A' . $row . ':T' . $row)->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => 'B5F556', // Green background color
                    ]
                ]
            ]);

            // Calculate totals for each result in the sub-account key
            foreach ($reportsByCode as $result) {
                $loan = $result->loans;
                $codeTotals['fin_law'] += (float)$result->fin_law;
                $codeTotals['current_loan'] += (float)$result->current_loan;

                if (!empty($loan)) {
                    $codeTotals['internal_increase'] += (float)$loan->internal_increase;
                    $codeTotals['unexpected_increase'] += (float)$loan->unexpected_increase;
                    $codeTotals['additional_increase'] += (float)$loan->additional_increase;
                    $codeTotals['decrease'] += (float)$loan->decrease;
                    $codeTotals['editorial'] += (float)$loan->editorial;
                    $codeTotals['new_credit_status'] += (float)$loan->new_credit_status;
                    $codeTotals['early_balance'] += (float)$loan->early_balance;
                    $codeTotals['apply'] += (float)$loan->apply;
                    $codeTotals['deadline_balance'] += (float)$loan->deadline_balance;
                    $codeTotals['credit'] += (float)$loan->credit;
                    $codeTotals['law_average'] += (float)$loan->law_average;
                    $codeTotals['law_correction'] += (float)$loan->law_correction;
                }

                // Calculate Law Average and Law Correction
                if ($codeTotals['fin_law'] != 0) {
                    $codeTotals['law_average'] = $codeTotals['deadline_balance'] / $codeTotals['fin_law'];
                } else {
                    $subAccountTotals['law_average'] = 0;
                }

                if ($codeTotals['new_credit_status'] != 0) {
                    $codeTotals['law_correction'] = $codeTotals['deadline_balance'] / $codeTotals['new_credit_status'];
                } else {
                    $codeTotals['law_correction'] = 0;
                }
            }


            if ($firstCode) {
                $sheet->setCellValue('A' . $row, $codeId);
                $sheet->setCellValue('E' . $row, $codeName);
                $sheet->setCellValue('F' . $row, $codeTotals['fin_law']); // Set financial law total
                $sheet->setCellValue('G' . $row, $codeTotals['current_loan']); // Set current loan total
                $sheet->setCellValue('H' . $row, $codeTotals['internal_increase']); // Set internal increase
                $sheet->setCellValue('I' . $row, $codeTotals['unexpected_increase']); // Set unexpected increase
                $sheet->setCellValue('J' . $row, $codeTotals['additional_increase']); // Set additional increase

                // Sum of all increases (internal, unexpected, additional)
                $sheet->setCellValue('K' . $row, $codeTotals['internal_increase'] + $codeTotals['unexpected_increase'] + $codeTotals['additional_increase']);

                // Set decrease total
                $sheet->setCellValue('L' . $row, $codeTotals['decrease']);

                // Set editorial, new credit status, and balances
                $sheet->setCellValue('M' . $row, $codeTotals['editorial']);
                $sheet->setCellValue('N' . $row, $codeTotals['new_credit_status']);
                $sheet->setCellValue('O' . $row, $codeTotals['early_balance']);
                $sheet->setCellValue('P' . $row, $codeTotals['apply']);
                $sheet->setCellValue('Q' . $row, $codeTotals['deadline_balance']);
                $sheet->setCellValue('R' . $row, $codeTotals['credit']);

                // Assume law_average and law_correction are calculated before setting
                $sheet->setCellValue('S' . $row, $codeTotals['law_average']);
                $sheet->setCellValue('T' . $row, $codeTotals['law_correction']);

                $firstCode = false;
                $row++;
            } else {
                // Hide repeated code and name
                $sheet->getStyle('A' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                $sheet->getStyle('E' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                $sheet->getStyle('F' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                $sheet->getStyle('G' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                $sheet->getStyle('H' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                $sheet->getStyle('I' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                $sheet->getStyle('J' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                $sheet->getStyle('K' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                $sheet->getStyle('L' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                $sheet->getStyle('M' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                $sheet->getStyle('N' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                $sheet->getStyle('O' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                $sheet->getStyle('P' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                $sheet->getStyle('Q' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                $sheet->getStyle('R' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                $sheet->getStyle('S' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                $sheet->getStyle('T' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                // Set background color to green
                // Set background color to green
                // Set background color to green
                $sheet->getRowDimension($row)->setRowHeight(-1);
            }

           

            // Group by accountKey within each code
            $groupedByAccountKey = $reportsByCode->groupBy(function ($result) {
                return $result->subAccountKey->accountKey->account_key ?? 'Unknown';
            });

            foreach ($groupedByAccountKey as $accountKeyId => $reportsByAccountKey) {
                $firstAccountKey = true; // Track if it's the first time showing the account_key

                $accountKeyName = $reportsByAccountKey->first()->subAccountKey->accountKey->name_account_key ?? 'Unknown';
                $accountTotals = [
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
                    'law_average' => 0,  // Calculated later
                    'law_correction' => 0, // Calculated later
                ];

                // Calculate totals for each result in the sub-account key
                foreach ($reportsByAccountKey as $result) {
                    $loan = $result->loans;
                    $accountTotals['fin_law'] += (float)$result->fin_law;
                    $accountTotals['current_loan'] += (float)$result->current_loan;

                    if (!empty($loan)) {
                        $accountTotals['internal_increase'] += (float)$loan->internal_increase;
                        $accountTotals['unexpected_increase'] += (float)$loan->unexpected_increase;
                        $accountTotals['additional_increase'] += (float)$loan->additional_increase;
                        $accountTotals['decrease'] += (float)$loan->decrease;
                        $accountTotals['editorial'] += (float)$loan->editorial;
                        $accountTotals['new_credit_status'] += (float)$loan->new_credit_status;
                        $accountTotals['early_balance'] += (float)$loan->early_balance;
                        $accountTotals['apply'] += (float)$loan->apply;
                        $accountTotals['deadline_balance'] += (float)$loan->deadline_balance;
                        $accountTotals['credit'] += (float)$loan->credit;
                        $accountTotals['law_average'] += (float)$loan->law_average;
                        $accountTotals['law_correction'] += (float)$loan->law_correction;
                    }

                    // Calculate Law Average and Law Correction
                    if ($accountTotals['fin_law'] != 0) {
                        $accountTotals['law_average'] = $accountTotals['deadline_balance'] / $accountTotals['fin_law'];
                    } else {
                        $subAccountTotals['law_average'] = 0;
                    }

                    if ($accountTotals['new_credit_status'] != 0) {
                        $accountTotals['law_correction'] = $accountTotals['deadline_balance'] / $accountTotals['new_credit_status'];
                    } else {
                        $accountTotals['law_correction'] = 0;
                    }
                }


                if ($firstAccountKey) {
                    $sheet->setCellValue('B' . $row, $accountKeyId); // Account Key ID
                    $sheet->setCellValue('E' . $row, $accountKeyName); // Account Key Name
                    $sheet->setCellValue('F' . $row, $accountTotals['fin_law']); // Account Key Name
                    $sheet->setCellValue('G' . $row, $accountTotals['current_loan']); // Account Key Name
                    $sheet->setCellValue('H' . $row, $accountTotals['internal_increase']); // Account Key Name
                    $sheet->setCellValue('I' . $row, $accountTotals['unexpected_increase']); // Account Key Name
                    $sheet->setCellValue('J' . $row, $accountTotals['additional_increase']); // Account Key Name
                    $sheet->setCellValue('K' . $row, $accountTotals['internal_increase'] + $accountTotals['unexpected_increase'] + $accountTotals['additional_increase']); // Account Key Name
                    $sheet->setCellValue('L' . $row, $accountTotals['decrease']); // Account Key Name
                    $sheet->setCellValue('M' . $row, $accountTotals['editorial']); // Account Key Name
                    $sheet->setCellValue('N' . $row, $accountTotals['new_credit_status']); // Account Key Name
                    $sheet->setCellValue('O' . $row, $accountTotals['early_balance']); // Account Key Name
                    $sheet->setCellValue('P' . $row, $accountTotals['apply']); // Account Key Name
                    $sheet->setCellValue('Q' . $row, $accountTotals['deadline_balance']); // Account Key Name
                    $sheet->setCellValue('R' . $row, $accountTotals['credit']); // Account Key Name
                    $sheet->setCellValue('S' . $row, $accountTotals['law_average']); // Account Key Name
                    $sheet->setCellValue('T' . $row, $accountTotals['law_correction']); // Account Key Name

                    $firstAccountKey = false;
                    $row++;
                } else {
                    // Hide repeated account_key and name
                    $sheet->getStyle('B' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    $sheet->getStyle('E' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    $sheet->getStyle('F' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    $sheet->getStyle('G' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    $sheet->getStyle('H' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    $sheet->getStyle('I' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    $sheet->getStyle('J' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    $sheet->getStyle('K' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    $sheet->getStyle('L' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    $sheet->getStyle('M' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    $sheet->getStyle('N' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    $sheet->getStyle('O' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    $sheet->getStyle('P' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    $sheet->getStyle('Q' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    $sheet->getStyle('R' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    $sheet->getStyle('S' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    $sheet->getStyle('T' . $row)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
                    // $sheet->getRowDimension($row)->setRowHeight(-1); 
                }

                // Group by subAccountKey within each accountKey
                $groupedBySubAccountKey = $reportsByAccountKey->groupBy(function ($result) {
                    return $result->subAccountKey->sub_account_key ?? 'Unknown';
                });



                foreach ($groupedBySubAccountKey as $subAccountKeyId => $reportsBySubAccountKey) {

                    // Initialize totals for each Sub Account Key
                    $firstSubAccountKey = true;
                    $subAccountKeyName = $reportsBySubAccountKey->first()->subAccountKey->name_sub_account_key ?? 'Unknown';

                    // Initialize total variables for sub-account calculations
                    $subAccountTotals = [
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
                        'law_correction' => 0
                    ];

                    // Calculate totals for each result in the sub-account key
                    foreach ($reportsBySubAccountKey as $result) {
                        $loan = $result->loans;
                        $subAccountTotals['fin_law'] += (float)$result->fin_law;
                        $subAccountTotals['current_loan'] += (float)$result->current_loan;

                        if (!empty($loan)) {
                            $subAccountTotals['internal_increase'] += (float)$loan->internal_increase;
                            $subAccountTotals['unexpected_increase'] += (float)$loan->unexpected_increase;
                            $subAccountTotals['additional_increase'] += (float)$loan->additional_increase;
                            $subAccountTotals['decrease'] += (float)$loan->decrease;
                            $subAccountTotals['editorial'] += (float)$loan->editorial;
                            $subAccountTotals['new_credit_status'] += (float)$loan->new_credit_status;
                            $subAccountTotals['early_balance'] += (float)$loan->early_balance;
                            $subAccountTotals['apply'] += (float)$loan->apply;
                            $subAccountTotals['deadline_balance'] += (float)$loan->deadline_balance;
                            $subAccountTotals['credit'] += (float)$loan->credit;
                            $subAccountTotals['law_average'] += (float)$loan->law_average;
                            $subAccountTotals['law_correction'] += (float)$loan->law_correction;
                        }

                        // Calculate Law Average and Law Correction
                        if ($subAccountTotals['fin_law'] != 0) {
                            $subAccountTotals['law_average'] = $subAccountTotals['deadline_balance'] / $subAccountTotals['fin_law'];
                        } else {
                            $subAccountTotals['law_average'] = 0;
                        }

                        if ($subAccountTotals['new_credit_status'] != 0) {
                            $subAccountTotals['law_correction'] = $subAccountTotals['deadline_balance'] / $subAccountTotals['new_credit_status'];
                        } else {
                            $subAccountTotals['law_correction'] = 0;
                        }
                    }
                    // Set values in the sheet for the first sub-account key
                    if ($firstSubAccountKey) {
                        $sheet->setCellValue('C' . $row, $subAccountKeyId); // Sub Account Key ID
                        $sheet->setCellValue('E' . $row, $subAccountKeyName); // Sub Account Key Name
                        $sheet->setCellValue('F' . $row, $subAccountTotals['fin_law']);
                        $sheet->setCellValue('G' . $row, $subAccountTotals['current_loan']);
                        $sheet->setCellValue('H' . $row, $subAccountTotals['internal_increase']);
                        $sheet->setCellValue('I' . $row, $subAccountTotals['unexpected_increase']);
                        $sheet->setCellValue('J' . $row, $subAccountTotals['additional_increase']);
                        $sheet->setCellValue('K' . $row, $subAccountTotals['internal_increase'] + $subAccountTotals['unexpected_increase'] + $subAccountTotals['additional_increase']);
                        $sheet->setCellValue('L' . $row, $subAccountTotals['decrease']);
                        $sheet->setCellValue('M' . $row, $subAccountTotals['editorial']);
                        $sheet->setCellValue('N' . $row, $subAccountTotals['new_credit_status']);
                        $sheet->setCellValue('O' . $row, $subAccountTotals['early_balance']);
                        $sheet->setCellValue('P' . $row, $subAccountTotals['apply']);
                        $sheet->setCellValue('Q' . $row, $subAccountTotals['deadline_balance']);
                        $sheet->setCellValue('R' . $row, $subAccountTotals['credit']);
                        $sheet->setCellValue('S' . $row, $subAccountTotals['law_average']);
                        $sheet->setCellValue('T' . $row, $subAccountTotals['law_correction']);

                        $firstSubAccountKey = false;
                        $row++;
                    }

                    // Process each report within the sub-account key and hide repeated values
                    foreach ($reportsBySubAccountKey as $result) {
                        $sheet->setCellValue('D' . $row, $subAccountKeyId); // Sub Account Key ID
                        $sheet->setCellValue('E' . $row, $subAccountKeyName); // Sub Account Key Name
                        $sheet->setCellValue('F' . $row, $subAccountTotals['fin_law']);
                        $sheet->setCellValue('G' . $row, $subAccountTotals['current_loan']);
                        $sheet->setCellValue('H' . $row, $subAccountTotals['internal_increase']);
                        $sheet->setCellValue('I' . $row, $subAccountTotals['unexpected_increase']);
                        $sheet->setCellValue('J' . $row, $subAccountTotals['additional_increase']);
                        $sheet->setCellValue('K' . $row, $subAccountTotals['internal_increase'] + $subAccountTotals['unexpected_increase'] + $subAccountTotals['additional_increase']);
                        $sheet->setCellValue('L' . $row, $subAccountTotals['decrease']);
                        $sheet->setCellValue('M' . $row, $subAccountTotals['editorial']);
                        $sheet->setCellValue('N' . $row, $subAccountTotals['new_credit_status']);
                        $sheet->setCellValue('O' . $row, $subAccountTotals['early_balance']);
                        $sheet->setCellValue('P' . $row, $subAccountTotals['apply']);
                        $sheet->setCellValue('Q' . $row, $subAccountTotals['deadline_balance']);
                        $sheet->setCellValue('R' . $row, $subAccountTotals['credit']);
                        $sheet->setCellValue('S' . $row, $subAccountTotals['law_average']);
                        $sheet->setCellValue('T' . $row, $subAccountTotals['law_correction']);

                        $sheet->getRowDimension($row)->setRowHeight(-1);

                        $row++; // Move to the next row
                    }
                }
            }
        }

        // Apply styles for the totals row
        $totalsStyleArray = [
            'font' => [
                'bold' => true,
                'size' => 8
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => '00FF00',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        // $sheet->getStyle("A{$row}:T{$row}")->applyFromArray($totalsStyleArray);

        // Save the modified spreadsheet as a new file or download directly
        $fileName = 'result_export.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }
}
