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
    private function calculateTotals($certificatesData)
    {
        $totals = [];
        $totals['total_amount_overall'] = 0;

        // Group by code (key code)
        $groupedByCode = $certificatesData->groupBy(function ($certificateData) {
            return optional($certificateData->report->subAccountKey->accountKey->key)->code ?? 'Unknown';
        });

        if ($groupedByCode->isEmpty()) {
            return $totals;  // Early return if no data found
        }

        foreach ($groupedByCode as $codeId => $certificatesByCode) {
            // Calculate totals for each code
            $totals['code'][$codeId] = $this->calculateSumFields($certificatesByCode);
            $totals['code'][$codeId]['name'] = optional($certificatesByCode->first()->report->subAccountKey->accountKey->key)->name ?? 'Unknown';

            $totals['total_amount_overall'] += $totals['code'][$codeId]['value_certificate'];

            // Group by accountKey within each codeId
            $groupedByAccountKey = $certificatesByCode->groupBy(function ($certificateData) {
                return optional($certificateData->report->subAccountKey->accountKey)->account_key ?? 'Unknown';
            });

            if ($groupedByAccountKey->isEmpty()) {
                continue;  // Skip if no account keys found for this code
            }

            foreach ($groupedByAccountKey as $accountKeyId => $certificatesByAccountKey) {
                // Calculate totals for each accountKey
                $totals['accountKey'][$codeId][$accountKeyId] = $this->calculateSumFields($certificatesByAccountKey);
                $totals['accountKey'][$codeId][$accountKeyId]['name_account_key'] = optional($certificatesByAccountKey->first()->report->subAccountKey->accountKey)->name_account_key ?? 'Unknown';

                // Group by subAccountKey within each accountKey
                $groupedBySubAccountKey = $certificatesByAccountKey->groupBy(function ($certificateData) {
                    return optional($certificateData->report->subAccountKey)->sub_account_key ?? 'Unknown';
                });

                if ($groupedBySubAccountKey->isEmpty()) {
                    continue;  // Skip if no sub-account keys found for this account key
                }

                foreach ($groupedBySubAccountKey as $subAccountKeyId => $certificatesBySubAccountKey) {
                    // Calculate totals for each subAccountKey
                    $totals['subAccountKey'][$codeId][$accountKeyId][$subAccountKeyId] = $this->calculateSumFields($certificatesBySubAccountKey);
                    $totals['subAccountKey'][$codeId][$accountKeyId][$subAccountKeyId]['name_sub_account_key'] = optional($certificatesBySubAccountKey->first()->report->subAccountKey)->name_sub_account_key ?? 'Unknown';

                    // Group by reportKey within each subAccountKey
                    $groupedByReportKey = $certificatesBySubAccountKey->groupBy(function ($certificateData) {
                        return optional($certificateData->report)->report_key ?? 'Unknown';
                    });

                    if ($groupedByReportKey->isEmpty()) {
                        continue;  // Skip if no report keys found for this sub-account key
                    }

                    foreach ($groupedByReportKey as $reportKeyId => $certificatesByReportKey) {
                        // Calculate totals for each reportKey
                        $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId] = $this->calculateSumFields($certificatesByReportKey);
                        $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId]['name_report_key'] = optional($certificatesByReportKey->first()->report)->name_report_key ?? 'Unknown';
                    }
                }
            }
        }

        return $totals;
    }


    private function calculateSumFields($certificateDataCollection)
    {
        // Initialize totals for each field
        $totals = [
            'value_certificate' => 0,
            'amount' => 0,
        ];

        // Sum each field
        foreach ($certificateDataCollection as $certificateData) {
            $totals['value_certificate'] += $certificateData->value_certificate ?? 0;
            $totals['amount'] += $certificateData->amount ?? 0;
        }

        return $totals;
    }
}
