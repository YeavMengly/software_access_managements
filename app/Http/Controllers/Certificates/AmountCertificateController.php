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
            })
            ->paginate(10);

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
        // initialize
        $totalAmountByGroup = [];
        $totalAmountOverall = 0;

        // use foeach loop 
        foreach ($certificatesData as $certificateData) {
            $code = $certificateData->report->subAccountKey->accountKey->key->code;
            $accountKey = $certificateData->report->subAccountKey->accountKey->account_key;
            $subAccountKey = $certificateData->report->subAccountKey->sub_account_key;

            // Define a unique key for grouping by code and account_key
            $groupKey = $code . '-' . $accountKey;

            // Initialize the group if not already present
            if (!isset($totalAmountByGroup[$groupKey])) {
                $totalAmountByGroup[$groupKey] = [];
            }

            // Sum the value_certificate for this sub_account_key within the group
            if (!isset($totalAmountByGroup[$groupKey][$subAccountKey])) {
                $totalAmountByGroup[$groupKey][$subAccountKey] = 0;
            }

            $totalAmountByGroup[$groupKey][$subAccountKey] += $certificateData->value_certificate;

            // Add to overall total
            $totalAmountOverall += $certificateData->value_certificate;
        }

        return [
            'total_amount_by_group' => $totalAmountByGroup,
            'total_amount_overall' => $totalAmountOverall,
        ];
    }
}
