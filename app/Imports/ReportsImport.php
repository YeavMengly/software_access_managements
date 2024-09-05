<?php

namespace App\Imports;

use App\Models\Code\Report;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class ReportsImport implements ToModel
{
    use Importable, SkipsFailures;

    /**
     * Process each row of the import.
     *
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Log the row data for debugging
        Log::info('Importing row: ' . json_encode($row));

        dd($row);

        // Skip empty rows or header rows
        if (isset($row['sub_account_key']) && !empty($row['sub_account_key'])) {
            $total_increase = $row['internal_increase'] + $row['unexpected_increase'] + $row['additional_increase'];
            $new_credit_status = $row['current_loan'] + $total_increase - $row['decrease'] - $row['editorial'];
            $deadline_balance = $row['early_balance'] + $row['apply'];
            $credit = $new_credit_status - $deadline_balance;
            $law_average = $deadline_balance != 0 ? $row['fin_law'] / $deadline_balance : 0;
            $law_correction = $deadline_balance != 0 ? $new_credit_status / $deadline_balance : 0;

            return new Report([
                'sub_account_key'     => $row['sub_account_key'],
                'report_key'          => $row['report_key'],
                'fin_law'             => $row['fin_law'] ?? 0,
                'current_loan'        => $row['current_loan'] ?? 0,
                'internal_increase'   => $row['internal_increase'] ?? 0,
                'unexpected_increase' => $row['unexpected_increase'] ?? 0,
                'additional_increase' => $row['additional_increase'] ?? 0,
                'total_increase'      => $total_increase,
                'decrease'            => $row['decrease'] ?? 0,
                'editorial'           => $row['editorial'] ?? 0,
                'early_balance'       => $row['early_balance'] ?? 0,
                'apply'               => $row['apply'] ?? 0,
                'deadline_balance'    => $deadline_balance,
                'credit'              => $credit,
                'law_average'         => $law_average,
                'law_correction'      => $law_correction,
            ]);
        }

        return null;
    }

    /**
     * Validation rules for the import.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'sub_account_key' => 'required|exists:sub_account_keys,id',
            'report_key' => 'required|string|max:255',
            'fin_law' => 'numeric|nullable',
            'current_loan' => 'numeric|nullable',
            'internal_increase' => 'numeric|nullable',
            'unexpected_increase' => 'numeric|nullable',
            'additional_increase' => 'numeric|nullable',
            'decrease' => 'numeric|nullable',
            'editorial' => 'numeric|nullable',
            'early_balance' => 'numeric|nullable',
            'apply' => 'numeric|nullable',
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'sub_account_key.required' => 'The sub account key is required.',
            'sub_account_key.exists'   => 'The selected sub account key does not exist.',
            'report_key.required'      => 'The report key is required.',
            'report_key.string'        => 'The report key must be a string.',
            'report_key.max'           => 'The report key may not be greater than 255 characters.',
            'numeric' => 'The :attribute must be a valid number.',
            'nullable' => 'The :attribute is optional.',
        ];
    }
}
