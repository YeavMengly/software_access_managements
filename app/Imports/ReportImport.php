<?php

namespace App\Imports;

use App\Models\Code\Report;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class ReportImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Log the row data for debugging
        Log::info('Processing row:', $row);

        // Check for required fields and handle missing values
        $subAccountKey = $row['sub_account_key'] ?? null;
        $reportKey = $row['report_key'] ?? null;

        if (is_null($subAccountKey) || is_null($reportKey)) {
            Log::warning('Skipping row due to missing required fields:', $row);
            return null; // Skip rows with missing essential keys
        }

        // Calculate total increase
        $totalIncrease = ($row['internal_increase'] ?? 0) + ($row['unexpected_increase'] ?? 0) + ($row['additional_increase'] ?? 0);

        // Calculate new credit status
        $newCreditStatus = ($row['current_loan'] ?? 0) + $totalIncrease - ($row['decrease'] ?? 0) - ($row['editorial'] ?? 0);

        // Calculate deadline balance
        $deadlineBalance = ($row['early_balance'] ?? 0) + ($row['apply'] ?? 0);

        // Calculate law averages
        $lawAverage = ($row['fin_law'] ?? 0) / max($deadlineBalance, 1); // Avoid division by zero
        $lawCorrection = $newCreditStatus / max($deadlineBalance, 1);

        // Log the computed values for debugging
        Log::info('Computed values:', [
            'total_increase' => $totalIncrease,
            'new_credit_status' => $newCreditStatus,
            'deadline_balance' => $deadlineBalance,
            'law_average' => $lawAverage,
            'law_correction' => $lawCorrection,
        ]);

        // Update or create the Report model
        return Report::updateOrCreate(
            [
                'sub_account_key' => $subAccountKey,
                'report_key' => $reportKey,
            ],
            [
                'name_report_key' => $row['name_report_key'] ?? '',
                'fin_law' => $row['fin_law'] ?? 0,
                'current_loan' => $row['current_loan'] ?? 0,
                'internal_increase' => $row['internal_increase'] ?? 0,
                'unexpected_increase' => $row['unexpected_increase'] ?? 0,
                'additional_increase' => $row['additional_increase'] ?? 0,
                'total_increase' => $totalIncrease,
                'decrease' => $row['decrease'] ?? 0,
                'editorial' => $row['editorial'] ?? 0,
                'new_credit_status' => $newCreditStatus,
                'early_balance' => $row['early_balance'] ?? 0,
                'apply' => $row['apply'] ?? 0,
                'deadline_balance' => $deadlineBalance,
                'credit' => $newCreditStatus - $deadlineBalance,
                'law_average' => $lawAverage,
                'law_correction' => $lawCorrection,
            ]
        );
    }
}
