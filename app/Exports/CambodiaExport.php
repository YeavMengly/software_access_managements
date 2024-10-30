<?php

namespace App\Exports;

use App\Models\Result\CambodiaMission;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CambodiaExport
{
    protected $search;
    protected $searchDate;

    public function __construct($search, $searchDate)
    {
        $this->search = $search;
        $this->searchDate = $searchDate;
    }

    public function export(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query the data from CambodiaMission based on search and searchDate
        $query = CambodiaMission::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Apply date range filter using created_at
        if ($startDate) {
            try {
                $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay()->toDateTimeString();
                if ($endDate) {
                    $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay()->toDateTimeString();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                } else {
                    $query->whereDate('created_at', '>=', $startDate);
                }
            } catch (\Exception $e) {
                // Handle invalid date format error
                Log::error('Invalid date format: ' . $e->getMessage());
                return redirect()->back()->withErrors(['date' => 'Invalid date format. Please use YYYY-MM-DD format.']);
            }
        }


        $missions = $query->get();

        /*
        |-------------------------------------------------------------------------------
        | Load the existing Excel template
        |-------------------------------------------------------------------------------
        */
        $templatePath = public_path('cambodia_export.xlsx');
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        /*
        |-------------------------------------------------------------------------------
        | Track the previous values and the start row for merging
        |-------------------------------------------------------------------------------
        */
        $prevLetterNumber = null;
        $mergeStartRowLetter = null;
        $row = 13;

        /*
        |-------------------------------------------------------------------------------
        | Initialize total variables
        |-------------------------------------------------------------------------------
        */
        $totalTravelAllowance = 0;
        $totalPocketMoney = 0;
        $totalMealMoney = 0;
        $totalAccommodationMoney = 0;
        $finalTotal = 0;

        // Initialize a counter for the "សរុប" rows
        $totalCounter = 1;

        // Initialize a counter for the overall iteration
        $mainIndex = 1;
        $subIndex = 0;

        foreach ($missions as $index => $mission) {
            $currentLetterNumber = $mission->letter_number;
            /*
            |-------------------------------------------------------------------------------
            | Check and merge letter_number and related columns
            |-------------------------------------------------------------------------------
            */
            if ($prevLetterNumber !== null && $currentLetterNumber !== $prevLetterNumber) {
                // Check if previous group had more than one person or just one person
                if ($mergeStartRowLetter !== null && $mergeStartRowLetter !== $row - 1) {
                    // Merge cells for the previous group
                    $sheet->mergeCells("A{$row}:J{$row}");
                    $sheet->mergeCells("E{$mergeStartRowLetter}:E" . ($row - 1));
                    $sheet->mergeCells("F{$mergeStartRowLetter}:F" . ($row - 1));
                    $sheet->mergeCells("G{$mergeStartRowLetter}:G" . ($row - 1));
                    $sheet->mergeCells("H{$mergeStartRowLetter}:H" . ($row - 1));

                    // Add totals in a new row
                    $sheet->setCellValue('A' . $row, 'សរុប' . str_pad($totalCounter, 2, '0', STR_PAD_LEFT));
                    $sheet->setCellValue('M' . $row, number_format($totalTravelAllowance, 0, '.', ','));
                    $sheet->setCellValue('O' . $row, number_format($totalPocketMoney, 0, '.', ','));
                    $sheet->setCellValue('Q' . $row, number_format($totalMealMoney, 0, '.', ','));
                    $sheet->setCellValue('S' . $row, number_format($totalAccommodationMoney, 0, '.', ','));
                    $sheet->setCellValue('U' . $row, number_format($finalTotal, 0, '.', ','));

                    // Center the text in the cell
                    $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                    // Apply font styles with bold
                    $styleArray = [
                        'font' => [
                            'name' => 'Khmer OS Muol Light',
                            'bold' => true,
                        ],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'argb' => 'D3D3D3',
                            ],
                        ],
                    ];

                    // Apply style to a range of cells
                    $sheet->getStyle('A' . $row . ':U' . $row)->applyFromArray($styleArray);
                    $sheet->getStyle('A' . $row)->applyFromArray($styleArray);
                    $sheet->getStyle('M' . $row)->applyFromArray($styleArray);
                    $sheet->getStyle('O' . $row)->applyFromArray($styleArray);
                    $sheet->getStyle('Q' . $row)->applyFromArray($styleArray);
                    $sheet->getStyle('S' . $row)->applyFromArray($styleArray);
                    $sheet->getStyle('U' . $row)->applyFromArray($styleArray);

                    $row++;

                    // Reset totals for the next group
                    $totalTravelAllowance = 0;
                    $totalPocketMoney = 0;
                    $totalMealMoney = 0;
                    $totalAccommodationMoney = 0;
                    $finalTotal = 0;

                    // Increment the counter for the next "Total" row
                    $totalCounter++;
                } else {
                    // Handle the case of a single-person group, no merging needed
                    $sheet->mergeCells("A{$row}:J{$row}");
                }

                // Add totals in a new row
                $sheet->setCellValue('A' . $row, 'សរុប' . str_pad($totalCounter, 2, '0', STR_PAD_LEFT));
                $sheet->setCellValue('M' . $row, number_format($totalTravelAllowance, 0, '.', ','));
                $sheet->setCellValue('O' . $row, number_format($totalPocketMoney, 0, '.', ','));
                $sheet->setCellValue('Q' . $row, number_format($totalMealMoney, 0, '.', ','));
                $sheet->setCellValue('S' . $row, number_format($totalAccommodationMoney, 0, '.', ','));
                $sheet->setCellValue('U' . $row, number_format($finalTotal, 0, '.', ','));

                // Center the text in the cell
                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Apply font styles with bold
                $styleArray = [
                    'font' => [
                        'name' => 'Khmer OS Muol Light',
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'D3D3D3',
                        ],
                    ],
                ];

                // Apply style to a range of cells
                $sheet->getStyle('A' . $row . ':U' . $row)->applyFromArray($styleArray);

                $row++;

                // Reset totals for the next group
                $totalTravelAllowance = 0;
                $totalPocketMoney = 0;
                $totalMealMoney = 0;
                $totalAccommodationMoney = 0;
                $finalTotal = 0;

                // Increment the counter for the next "Total" row
                $totalCounter++;
                $mergeStartRowLetter = $row;
            }

            // If it's the first time, set the mergeStartRowLetter
            if ($prevLetterNumber === null || $currentLetterNumber !== $prevLetterNumber) {
                $mergeStartRowLetter = $row;
            }
        
            /* 
            |-------------------------------------------------------------------------------
            | Populate data
            |-------------------------------------------------------------------------------
            */
            // Check if the letter number has changed
            if ($prevLetterNumber !== null && $currentLetterNumber !== $prevLetterNumber) {
                $mainIndex++;
                $subIndex = 0;
            }
            // Increment sub-index for each mission in the current group
            $subIndex++;
            $sheet->setCellValue('A' . $row, "{$mainIndex}.{$subIndex}");
            $sheet->setCellValue('B' . $row, $mission->name);
            $sheet->setCellValue('C' . $row, $mission->role);
            $sheet->setCellValue('D' . $row, $mission->position_type);
            $sheet->setCellValue('E' . $row, $mission->letter_number);
            $sheet->setCellValue('F' . $row, Date::PHPToExcel($mission->letter_date));
            $sheet->setCellValue('G' . $row, $mission->mission_objective);
            $sheet->setCellValue('H' . $row, $mission->location);
            $sheet->setCellValue('I' . $row, Date::PHPToExcel($mission->mission_start_date));
            $sheet->setCellValue('J' . $row, Date::PHPToExcel($mission->mission_end_date));
            $sheet->setCellValue('K' . $row, $mission->days_count);
            $sheet->setCellValue('L' . $row, $mission->nights_count);
            $sheet->setCellValue('M' . $row, number_format($mission->travel_allowance, 0, '.', ','));
            $sheet->setCellValue('N' . $row, number_format($mission->pocket_money, 0, '.', ','));
            $sheet->setCellValue('O' . $row, number_format($mission->total_pocket_money, 0, '.', ','));
            $sheet->setCellValue('P' . $row, number_format($mission->meal_money, 0, '.', ','));
            $sheet->setCellValue('Q' . $row, number_format($mission->total_meal_money, 0, '.', ','));
            $sheet->setCellValue('R' . $row, number_format($mission->accommodation_money, 0, '.', ','));
            $sheet->setCellValue('S' . $row, number_format($mission->total_accommodation_money, 0, '.', ','));
            $sheet->setCellValue('T' . $row, number_format($mission->other_allowances, 0, '.', ','));
            $sheet->setCellValue('U' . $row, number_format($mission->final_total, 0, '.', ','));

            // Apply date format to the cells
            $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('dd-mmm-yyyy');
            $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('dd-mmm-yyyy');
            $sheet->getStyle('J' . $row)->getNumberFormat()->setFormatCode('dd-mmm-yyyy');

            // Update totals
            $totalTravelAllowance += $mission->travel_allowance;
            $totalPocketMoney += $mission->total_pocket_money;
            $totalMealMoney += $mission->total_meal_money;
            $totalAccommodationMoney += $mission->total_accommodation_money;
            $finalTotal += $mission->final_total;

            // Update the previous letter_number
            $prevLetterNumber = $currentLetterNumber;
            $row++;
        }
        /*
        |-------------------------------------------------------------------------------
        | Merge and add totals for the last group if needed
        |-------------------------------------------------------------------------------
        */
        if ($mergeStartRowLetter !== null && $mergeStartRowLetter !== $row - 1) {
            // Merge the last group's columns
            $sheet->mergeCells("E{$mergeStartRowLetter}:E" . ($row - 1));
            $sheet->mergeCells("F{$mergeStartRowLetter}:F" . ($row - 1));
            $sheet->mergeCells("G{$mergeStartRowLetter}:G" . ($row - 1));
            $sheet->mergeCells("H{$mergeStartRowLetter}:H" . ($row - 1));
            $sheet->mergeCells("A{$row}:J{$row}");
        // Handle the last group (single or multi-person group)
        if ($prevLetterNumber !== null) {
            if ($mergeStartRowLetter !== null && $mergeStartRowLetter !== $row - 1) {
                $sheet->mergeCells("A{$row}:J{$row}");
                $sheet->mergeCells("E{$mergeStartRowLetter}:E" . ($row - 1));
                $sheet->mergeCells("F{$mergeStartRowLetter}:F" . ($row - 1));
                $sheet->mergeCells("G{$mergeStartRowLetter}:G" . ($row - 1));
                $sheet->mergeCells("H{$mergeStartRowLetter}:H" . ($row - 1));
            } else {
                // Single person group, no merging
                $sheet->mergeCells("A{$row}:J{$row}");
            }

            // Add totals for the last group
            $sheet->setCellValue('A' . $row, 'សរុប' . str_pad($totalCounter, 2, '0', STR_PAD_LEFT));
            $sheet->setCellValue('M' . $row, number_format($totalTravelAllowance, 0, '.', ','));
            $sheet->setCellValue('O' . $row, number_format($totalPocketMoney, 0, '.', ','));
            $sheet->setCellValue('Q' . $row, number_format($totalMealMoney, 0, '.', ','));
            $sheet->setCellValue('S' . $row, number_format($totalAccommodationMoney, 0, '.', ','));
            $sheet->setCellValue('U' . $row, number_format($finalTotal, 0, '.', ','));
            // Center the text in the cell
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            // Apply font styles with bold
            $styleArray = [
                'font' => [
                    'name' => 'Khmer OS Muol Light',
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'D3D3D3',
                    ],
                ],
            ];

            // Apply the style to the range of cells
            $sheet->getStyle('A' . $row . ':U' . $row)->applyFromArray($styleArray);
            $sheet->getStyle('A' . $row)->applyFromArray($styleArray);
            $sheet->getStyle('M' . $row)->applyFromArray($styleArray);
            $sheet->getStyle('O' . $row)->applyFromArray($styleArray);
            $sheet->getStyle('Q' . $row)->applyFromArray($styleArray);
            $sheet->getStyle('S' . $row)->applyFromArray($styleArray);
            $sheet->getStyle('U' . $row)->applyFromArray($styleArray);
            // Apply styles to the last total row
            $sheet->getStyle('A' . $row . ':U' . $row)->applyFromArray($styleArray);
        }


        /*
        |-------------------------------------------------------------------------------
        | Merge and add totals for the last group if needed
        |-------------------------------------------------------------------------------
        */
        if ($mergeStartRowLetter !== null) {
            // Check if the group has more than one person, or if it's a single person group
            if ($mergeStartRowLetter !== $row - 1 || $mergeStartRowLetter === $row - 1) {
                // Merge columns for multi-row groups
                if ($mergeStartRowLetter !== $row - 1) {
                    $sheet->mergeCells("E{$mergeStartRowLetter}:E" . ($row - 1));
                    $sheet->mergeCells("F{$mergeStartRowLetter}:F" . ($row - 1));
                    $sheet->mergeCells("G{$mergeStartRowLetter}:G" . ($row - 1));
                    $sheet->mergeCells("H{$mergeStartRowLetter}:H" . ($row - 1));
                }

                // Add totals for the group (including single person group)
                $sheet->mergeCells("A{$row}:J{$row}");
                $sheet->setCellValue('A' . $row, 'សរុប' . str_pad($totalCounter, 2, '0', STR_PAD_LEFT));
                $sheet->setCellValue('M' . $row, number_format($totalTravelAllowance, 0, '.', ','));
                $sheet->setCellValue('O' . $row, number_format($totalPocketMoney, 0, '.', ','));
                $sheet->setCellValue('Q' . $row, number_format($totalMealMoney, 0, '.', ','));
                $sheet->setCellValue('S' . $row, number_format($totalAccommodationMoney, 0, '.', ','));
                $sheet->setCellValue('U' . $row, number_format($finalTotal, 0, '.', ','));

                // Center the text in the cell
                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Apply font styles with bold
                $styleArray = [
                    'font' => [
                        'name' => 'Khmer OS Muol Light',
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'D3D3D3',
                        ],
                    ],
                ];

                // Apply the style to the range of cells
                $sheet->getStyle('A' . $row . ':U' . $row)->applyFromArray($styleArray);
                $sheet->getStyle('A' . $row)->applyFromArray($styleArray);
                $sheet->getStyle('M' . $row)->applyFromArray($styleArray);
                $sheet->getStyle('O' . $row)->applyFromArray($styleArray);
                $sheet->getStyle('Q' . $row)->applyFromArray($styleArray);
                $sheet->getStyle('S' . $row)->applyFromArray($styleArray);
                $sheet->getStyle('U' . $row)->applyFromArray($styleArray);
            }
        }


        // Save the modified spreadsheet as a new file or download directly
        $fileName = 'cambodia_export.xlsx';

        // Set headers to download the file
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
}