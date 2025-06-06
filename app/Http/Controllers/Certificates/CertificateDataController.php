<?php

namespace App\Http\Controllers\Certificates;

use App\Http\Controllers\Controller;
use App\Models\Certificates\CertificateData;
use App\Models\Code\AccountKey;
use App\Models\Code\Key;
use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use App\Models\Mission\MissionType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CertificateDataController extends Controller
{
    public function index(Request $request)
    {
        $missionTypes = MissionType::all();
        $search              = $request->input('search');
        $subAccountKeyId     = $request->input('sub_account_key_id');
        $reportKey           = $request->input('report_key');
        $selectedMissionType = $request->input('mission_type');
        $startDate           = $request->input('start_date');
        $endDate             = $request->input('end_date');
        $sortField     = $request->input('sort_field', 'value_certificate');
        $sortDirection = $request->input('sort_direction', 'asc');
        $perPage       = $request->input('per_page', 25);

        // Validate the sort field
        if (!in_array($sortField, ['value_certificate', 'report_key'])) {
            $sortField = 'value_certificate';
        }

        // Build the query
        $query = CertificateData::with(['report.subAccountKey.accountKey.key', 'missionType'])
            ->whereHas('report.year', function ($query) {
                $query->where('status', 'active');
            })
            ->when($search, function ($query, $search) {
                $query->whereHas('report.subAccountKey', function ($query) use ($search) {
                    $query->where('sub_account_key', 'like', "%{$search}%");
                });
            })
            ->when($subAccountKeyId, function ($query, $subAccountKeyId) {
                $query->whereHas('report.subAccountKey', function ($query) use ($subAccountKeyId) {
                    $query->where('sub_account_key', 'like', "%{$subAccountKeyId}%");
                });
            })
            ->when($reportKey, function ($query, $reportKey) {
                $query->whereHas('report', function ($query) use ($reportKey) {
                    $query->where('report_key', 'like', "%{$reportKey}%");
                });
            })
            ->when($selectedMissionType, function ($query, $selectedMissionType) {
                $query->where('mission_type', $selectedMissionType);
            })
            ->when($startDate, function ($query, $startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            });

        // Calculate totals and paginate the results
        $totalAmount      = $query->sum('value_certificate');
        $certificatesData = $query->orderBy($sortField, $sortDirection)->paginate($perPage);
        $totals           = $this->calculateTotals($certificatesData);
        $dataAvailable    = $certificatesData->isNotEmpty();

        return view('layouts.admin.forms.certificate.certificate-data-index', compact(
            'certificatesData',
            'totals',
            'dataAvailable',
            'totalAmount',
            'selectedMissionType',
            'missionTypes'
        ));
    }

    public function create()
    {
        $keys = Key::all();
        $accountKeys = AccountKey::all();
        $subAccountKeys = SubAccountKey::all();
        $reports = Report::whereHas('year', function ($query) {
            $query->where('status', 'active')
                ->where('date_year', '>=', Carbon::now()->startOfYear());
        })->get();
        $missionTypes = MissionType::all();

        return view('layouts.admin.forms.certificate.certificate-data-create', compact('reports', 'subAccountKeys', 'accountKeys', 'keys', 'missionTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'value_certificate' => 'required|numeric|min:0',
            'mission_type' => 'required|exists:mission_types,id',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf|max:2048',
            'date_certificate' => 'required|date'
        ]);

        $report = Report::findOrFail($validated['report_key']);
        if (!$report || !$report->subAccountKey) {
            return redirect()->back()->withErrors(['error' => 'មិនមាន អនុគណនី ឬកូដកម្មវិធី។']);
        }
        $applyValue = $validated['value_certificate'];
        $remainingCredit = $report->credit - $applyValue;

        if ($remainingCredit < 0) {
            return redirect()->back()->withErrors(['error' => 'ឥណាទានមិនអាចតិចជាងសូន្យ។']);
        }

        $storedFilePaths = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file->isValid()) {
                    $filePath = $file->store('certificateDatas', 'public');
                    $storedFilePaths[] = $filePath;
                }
            }
        }
        CertificateData::create([
            'report_key' => $validated['report_key'],
            'value_certificate' => $applyValue,
            'mission_type' => $validated['mission_type'],
            'attachments' => json_encode($storedFilePaths),
            'date_certificate' => $validated['date_certificate']
        ]);
        $this->recalculateAndSaveReport($report);

        $report->refresh();
        $lastCertificateData = CertificateData::where('report_key', $validated['report_key'])->latest()->first();
        $report->apply = $lastCertificateData->value_certificate;
        $report->save();

        return redirect()->route('certificate-data.create')->with('success', 'សលាកបត្របានបញ្ចូលដោយជោគជ័យ');
    }

    public function show($id)
    {
        $certificateData = CertificateData::with('certificate')->findOrFail($id);
        return view('certificate-data.show', compact('certificateData'));
    }

    public function getEarlyBalance($id)
    {
        $report = Report::find($id);
        $loan = $report ? $report->loans : null;

        if ($report) {
            $credit_movement = ($loan->total_increase ?? 0) - ($loan->decrease ?? 0);
            return response()->json([
                'fin_law' => $report->fin_law,
                'credit_movement' =>  $credit_movement,
                'new_credit_status' => $report->new_credit_status,
                'credit' => $report->credit,
                'deadline_balance' => $report->deadline_balance,
            ]);
        }

        return response()->json([
            'fin_law' => 0,
            'credit_movement' => 0,
            'new_credit_status' => 0,
            'credit' => 0,
            'deadline_balance' => 0,
        ]);
    }

    public function edit($id)
    {
        $certificateData = CertificateData::findOrFail($id); // Retrieve the certificate data by ID
        $keys = Key::all();
        $accountKeys = AccountKey::all();
        $subAccountKeys = SubAccountKey::all();
        $reports = Report::whereHas('year', function ($query) {
            $query->where('status', 'active')
                ->where('date_year', '>=', Carbon::now()->startOfYear());
        })->get();
        $missionTypes = MissionType::all();
        return view('layouts.admin.forms.certificate.certificate-data-edit', compact(
            'certificateData',
            'reports',
            'subAccountKeys',
            'accountKeys',
            'keys',
            'missionTypes'
        ));
    }

    public function update(Request $request, $id)
    {
        $certificateData = CertificateData::findOrFail($id);

        $validated = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'value_certificate' => 'required|numeric|min:0',
            'mission_type' => 'required|exists:mission_types,id',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf|max:2048',
            'date_certificate' => 'required|date'
        ]);

        $report = Report::findOrFail($validated['report_key']);
        if (!$report || !$report->subAccountKey) {
            return redirect()->back()->withErrors(['error' => 'មិនមាន អនុគណនី ឬកូដកម្មវិធី។']);
        }

        $applyValue = $validated['value_certificate'];
        $remainingCredit = $report->credit - $applyValue + $certificateData->value_certificate;

        if ($remainingCredit < 0) {
            return redirect()->back()->withErrors(['error' => 'ឥណាទានមិនអាចតិចជាងសូន្យ។']);
        }

        $storedFilePaths = json_decode($certificateData->attachments, true) ?? [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file->isValid()) {
                    $filePath = $file->store('certificateDatas', 'public');
                    $storedFilePaths[] = $filePath;
                }
            }
        }

        $certificateData->update([
            'report_key' => $validated['report_key'],
            'value_certificate' => $applyValue,
            'mission_type' => $validated['mission_type'],
            'attachments' => json_encode($storedFilePaths),
            'date_certificate' => $validated['date_certificate']
        ]);

        $this->recalculateAndSaveReport($report);

        return redirect()->route('certificate-data.index', $id)
            ->with('success', 'សលាកបត្របានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ');
    }

    public function destroy($id)
    {
        $certificateData = CertificateData::findOrFail($id);
        $report = Report::findOrFail($certificateData->report_key);

        $certificateData->delete();
        $validatedData['internal_increase'] = $validatedData['internal_increase'] ?? 0;
        $validatedData['unexpected_increase'] = $validatedData['unexpected_increase'] ?? 0;
        $validatedData['additional_increase'] = $validatedData['additional_increase'] ?? 0;
        $validatedData['decrease'] = $validatedData['decrease'] ?? 0;
        $validatedData['editorial'] = $validatedData['editorial'] ?? 0;

        $current_loan = $report->current_loan;
        $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];
        $new_credit_status = $current_loan + $total_increase - $validatedData['decrease'] - $validatedData['editorial'];
        $newApplyTotal = CertificateData::where('report_key', $report->id)->sum('value_certificate');
        $report->apply = $newApplyTotal > 0 ? $newApplyTotal : 0;
        $report->deadline_balance = $report->early_balance + $report->apply;
        $credit = $new_credit_status -  $report->deadline_balance;
        $report->update([
            $credit
        ]);
        $report->save();
        $this->recalculateAndSaveReport($report);
        return redirect()->route('certificate-data.index')->with('success', 'សលាកបត្របានលុបដោយជោគជ័យ។');
    }

    private function recalculateAndSaveReport(Report $report)
    {
        $newApplyTotal = CertificateData::where('report_key', $report->id)
            ->latest('created_at') // Order by latest created record
            ->value('value_certificate') ?? 0;
        $report->early_balance = $this->calculateEarlyBalance($report);

        $report->apply = $newApplyTotal;
        $credit = $report->new_credit_status - $report->deadline_balance;
        $report->credit = $credit;
        $report->deadline_balance = $report->early_balance + $report->apply;
        $report->credit = $report->new_credit_status - $report->deadline_balance;
        $report->law_average = $report->deadline_balance > 0 ? ($report->deadline_balance / $report->fin_law) * 100 : 0;
        $report->law_correction =  $report->deadline_balance > 0 ? ($report->deadline_balance /  $report->new_credit_status) * 100 : 0;

        $report->save();
    }

    private function calculateEarlyBalance($report)
    {
        $certificateData = CertificateData::where('report_key', $report->id)->get();

        if ($certificateData->count() === 1) {
            return 0;
        }

        $totalEarlyBalance = $certificateData->slice(0, -1)
            ->filter(function ($item) {
                return !is_null($item->value_certificate) && $item->value_certificate !== '';
            })
            ->sum('value_certificate');

        return $totalEarlyBalance ?: 0;
    }


    private function calculateTotals($certificatesData)
    {
        $totals = [];
        $totals['total_amount_overall'] = 0;

        $groupedByCode = $certificatesData->groupBy(function ($certificateData) {
            return optional($certificateData->report->subAccountKey->accountKey->key)->code ?? 'Unknown';
        });

        foreach ($groupedByCode as $codeId => $certificatesByCode) {
            $totals['code'][$codeId] = $this->calculateSumFields($certificatesByCode);
            $totals['total_amount_overall'] += $totals['code'][$codeId]['value_certificate'];

            // Group by accountKey within each codeId
            $groupedByAccountKey = $certificatesByCode->groupBy(function ($certificateData) {
                return optional($certificateData->report->subAccountKey->accountKey)->account_key ?? 'Unknown';
            });

            foreach ($groupedByAccountKey as $accountKeyId => $certificatesByAccountKey) {
                $totals['accountKey'][$codeId][$accountKeyId] = $this->calculateSumFields($certificatesByAccountKey);

                // Group by subAccountKey within each accountKey
                $groupedBySubAccountKey = $certificatesByAccountKey->groupBy(function ($certificateData) {
                    return optional($certificateData->report->subAccountKey)->sub_account_key ?? 'Unknown';
                });

                foreach ($groupedBySubAccountKey as $subAccountKeyId => $certificatesBySubAccountKey) {
                    $totals['subAccountKey'][$codeId][$accountKeyId][$subAccountKeyId] = $this->calculateSumFields($certificatesBySubAccountKey);

                    // Group by reportKey within each subAccountKey
                    $groupedByReportKey = $certificatesBySubAccountKey->groupBy(function ($certificateData) {
                        return optional($certificateData->report)->report_key ?? 'Unknown';
                    });

                    foreach ($groupedByReportKey as $reportKeyId => $certificatesByReportKey) {
                        $totals['reportKey'][$codeId][$accountKeyId][$subAccountKeyId][$reportKeyId] = $this->calculateSumFields($certificatesByReportKey);
                    }
                }
            }
        }

        return $totals;
    }

    private function calculateSumFields($certificateDataCollection)
    {
        $totals = [
            'value_certificate' => 0,
            'amount' => 0,
        ];

        foreach ($certificateDataCollection as $certificateData) {
            $totals['value_certificate'] += $certificateData->value_certificate ?? 0;
            $totals['amount'] += $certificateData->amount ?? 0;
        }

        return $totals;
    }
}
