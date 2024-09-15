<?php

namespace App\Http\Controllers\Certificates;

use App\Http\Controllers\Controller;
use App\Models\Certificates\CertificateData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AmountCertificateController extends Controller
{
    public function index(Request $request)
    {
        // make object varriable
        $search = $request->input('search');
        $sortField = $request->input('sort_field', 'id'); // Default sort field
        $sortDirection = $request->input('sort_direction', 'asc'); // Default sort direction

        $certificatesData = CertificateData::with(['certificate', 'report.subAccountKey.accountKey.key'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('certificate', function ($query) use ($search) {
                    $query->where('name_certificate', 'like', "%{$search}%");
                });
            })
            ->when($sortField === 'account_key', function ($query) use ($sortDirection) {
                // Adjust the sorting to reference the related table column
                return $query->join('reports', 'certificate_data.report_id', '=', 'reports.id')
                    ->join('sub_account_keys', 'reports.sub_account_key_id', '=', 'sub_account_keys.id')
                    ->join('account_keys', 'sub_account_keys.account_key_id', '=', 'account_keys.id')
                    ->orderBy('account_keys.account_key', $sortDirection);
            }, function ($query) use ($sortField, $sortDirection) {
                // Default sorting
                return $query->orderBy($sortField, $sortDirection);
            })->paginate(10);

        // Calculate totals
        $totals = $this->calculateTotals($certificatesData);

        return view(
            'layouts.admin.forms.certificate.amount.certificate-amount',
            compact('certificatesData', 'totals', 'sortField', 'sortDirection')
        );
    }

    // Funtion calculateTotals 
    private function calculateTotals($certificatesData)
    {
        // Initialize totals
        $totalAmountByGroup = [];
        $totalAmountByKey = [];
        $totalAmountByAccountKey = [];
        $totalAmountByReportKey = []; // New array for totals by report_key
        $totalAmountOverall = 0;

        // Loop through each certificate data entry
        foreach ($certificatesData as $certificateData) {
            // Safely access related models using optional()
            $report = optional($certificateData->report);
            $subAccountKey = optional($report->subAccountKey);
            $accountKey = optional($subAccountKey->accountKey);

            // Safely extract values or default to 'N/A'
            $code = optional($accountKey->key)->code ?? 'N/A';
            $accountKeyValue = $accountKey->account_key ?? 'N/A';
            $subAccountKeyValue = $subAccountKey->sub_account_key ?? 'N/A';
            $reportKey = $report->report_key ?? 'N/A'; // Extract the report_key

            // Define unique keys for grouping
            $groupAccountKey = $code;
            $groupSubAccountKey = $code . '-' . $accountKeyValue;

            // Initialize the group if not already present
            if (!isset($totalAmountByGroup[$groupSubAccountKey])) {
                $totalAmountByGroup[$groupSubAccountKey] = [];
            }

            // Initialize the total for this key if not already set
            if (!isset($totalAmountByKey[$code])) {
                $totalAmountByKey[$code] = 0;
            }

            // Initialize the total for this accountKey if not already set
            if (!isset($totalAmountByAccountKey[$groupAccountKey][$accountKeyValue])) {
                $totalAmountByAccountKey[$groupAccountKey][$accountKeyValue] = 0;
            }

            // Initialize the total for this report_key if not already set
            if (!isset($totalAmountByReportKey[$reportKey])) {
                $totalAmountByReportKey[$reportKey] = 0;
            }

            // Sum the value_certificate for this sub_account_key within the group
            if (!isset($totalAmountByGroup[$groupSubAccountKey][$subAccountKeyValue])) {
                $totalAmountByGroup[$groupSubAccountKey][$subAccountKeyValue] = 0;
            }

            // Add the value_certificate to the total for this key
            $totalAmountByKey[$code] += $certificateData->value_certificate;

            // Add the value_certificate to the total for this accountKey
            $totalAmountByAccountKey[$groupAccountKey][$accountKeyValue] += $certificateData->value_certificate;

            // Add the value_certificate to the total for this sub_account_key within the group
            $totalAmountByGroup[$groupSubAccountKey][$subAccountKeyValue] += $certificateData->value_certificate;

            // Add the value_certificate to the total for this report_key
            $totalAmountByReportKey[$reportKey] += $certificateData->value_certificate;

            // Add to overall total
            $totalAmountOverall += $certificateData->value_certificate;
        }

        // Return the calculated totals after the loop
        return [
            'total_amount_by_key' => $totalAmountByKey,
            'total_amount_by_account_key' => $totalAmountByAccountKey,
            'total_amount_by_group' => $totalAmountByGroup,
            'total_amount_by_report_key' => $totalAmountByReportKey, // Include the new total
            'total_amount_overall' => $totalAmountOverall,
        ];
    }
}
