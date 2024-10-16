<?php

namespace App\Http\Controllers\Certificates;

use App\Http\Controllers\Controller;
use App\Models\Certificates\Certificate;
use App\Models\Certificates\CertificateData;
use App\Models\Code\AccountKey;
use App\Models\Code\Key;
use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use Illuminate\Http\Request;

class CertificateDataController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortField = $request->input('sort_field', 'name_certificate');
        $sortDirection = $request->input('sort_direction', 'asc');
        $perPage = $request->input('per_page', 25);

        if (!in_array($sortField, ['name_certificate', 'value_certificate', 'other_valid_column'])) {
            $sortField = 'name_certificate';
        }

        // Fetch certificate data with an optional search filter and sorting
        $certificatesData = CertificateData::with(['certificate', 'report.subAccountKey.accountKey.key'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('certificate', function ($query) use ($search) {
                    $query->where('name_certificate', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);


        $dataAvailable = $certificatesData->isNotEmpty();

        return view('layouts.admin.forms.certificate.certificate-data-index', compact('certificatesData', 'dataAvailable'));
    }


    public function create()
    {
        $keys = Key::all();
        $accountKeys = AccountKey::all();
        $subAccountKeys = SubAccountKey::all();
        $reports = Report::all();
        $certificates = Certificate::all();

        return view('layouts.admin.forms.certificate.certificate-data-create', compact('certificates', 'reports', 'subAccountKeys', 'accountKeys', 'keys'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'name_certificate' => 'required|exists:certificates,id',
            'value_certificate' => 'required|numeric',
        ]);

        $report = Report::findOrFail($validated['report_key']);
        $certificate = Certificate::findOrFail($validated['name_certificate']);

        if (!$report || !$report->subAccountKey) {
            return redirect()->back()->withErrors(['error' => 'Invalid report or sub-account key.']);
        }

        // Check for uniqueness of name_certificate within the same report_key
        $existingCertificateData = CertificateData::where('report_key', $validated['report_key'])
            ->where('name_certificate', $validated['name_certificate'])
            ->first();

        if ($existingCertificateData) {
            return redirect()->back()->withErrors(['name_certificate' => 'The name_certificate must be unique within the same report.'])->withInput();
        }

        // Create the certificate data
        CertificateData::create([
            'report_key' => $validated['report_key'],
            'name_certificate' => $validated['name_certificate'],
            'value_certificate' => $validated['value_certificate'],
        ]);

        // Recalculate and save report values
        $this->recalculateAndSaveReport($report);

        return redirect()->route('certificate-data.index')->with('success', 'Certificate data created successfully.');
    }

    public function show($id)
    {
        $certificateData = CertificateData::with('certificate')->findOrFail($id);
        return view('certificate-data.show', compact('certificateData'));
    }

    public function edit($id)
    {
        $certificateData = CertificateData::findOrFail($id);
        $certificates = Certificate::all();
        $reports = Report::all();
        $subAccountKeys = SubAccountKey::all();
        $accountKeys = AccountKey::all();
        $keys = Key::all();

        return view('layouts.admin.forms.certificate.certificate-data-edit', compact('certificateData', 'certificates', 'reports', 'subAccountKeys', 'accountKeys', 'keys'));
    }

    // public function update(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'report_key' => 'required|exists:reports,id',
    //         'name_certificate' => 'required|exists:certificates,id',
    //         'value_certificate' => 'required|numeric',
    //     ]);

    //     $certificateData = CertificateData::findOrFail($id);
    //     $report = Report::findOrFail($validated['report_key']);

    //     if (!$report->subAccountKey) {
    //         return redirect()->route('certificate-data.index')->with('error', 'SubAccountKey not found for the selected report.');
    //     }

    //     $subAccountKey = $report->subAccountKey;

    //     if (!$subAccountKey->accountKey) {
    //         return redirect()->route('certificate-data.index')->with('error', 'AccountKey not found for the selected sub-account.');
    //     }

    //     $accountKey = $subAccountKey->accountKey;

    //     // Recalculate apply total
    //     $newApplyTotal = CertificateData::where('report_key', $validated['report_key'])
    //         ->where('id', '<>', $certificateData->id)
    //         ->sum('value_certificate');
    //     $newApplyTotal += $validated['value_certificate'];

    //     $report->apply = $newApplyTotal;
    //     $report->deadline_balance = $report->early_balance + $newApplyTotal;
    //     $report->save();

    //     $certificateData->update([
    //         'report_key' => $validated['report_key'],
    //         'name_certificate' => $validated['name_certificate'],
    //         'value_certificate' => $validated['value_certificate'],
    //         'amount' => $newApplyTotal,
    //     ]);

    //     return redirect()->route('certificate-data.index')->with('success', 'Certificate data updated successfully.');
    // }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'name_certificate' => 'required|exists:certificates,id',
            'value_certificate' => 'required|numeric',
        ]);

        $certificateData = CertificateData::findOrFail($id);
        $report = Report::findOrFail($validated['report_key']);

        if (!$report->subAccountKey) {
            return redirect()->route('certificate-data.index')->with('error', 'SubAccountKey not found for the selected report.');
        }

        $certificateData->update([
            'report_key' => $validated['report_key'],
            'name_certificate' => $validated['name_certificate'],
            'value_certificate' => $validated['value_certificate'],
        ]);

        // Recalculate and save report values
        $this->recalculateAndSaveReport($report);

        return redirect()->route('certificate-data.index')->with('success', 'Certificate data updated successfully.');
    }

    public function destroy($id)
    {
        $certificateData = CertificateData::findOrFail($id);
        $report = Report::findOrFail($certificateData->report_key);

        $certificateData->delete();

        // Recalculate the total value_certificate for the report
        $newApplyTotal = CertificateData::where('report_key', $report->id)->sum('value_certificate');
        $report->apply = $newApplyTotal > 0 ? $newApplyTotal : 0;
        $report->deadline_balance = $report->early_balance + $report->apply;
        $report->save();

        return redirect()->route('certificate-data.index')->with('success', 'Certificate data deleted successfully.');
    }


    private function recalculateAndSaveReport(Report $report)
    {
        // Recalculate apply total
        $newApplyTotal = CertificateData::where('report_key', $report->id)->sum('value_certificate');
        $report->apply = $newApplyTotal;

        // Recalculate deadline_balance
        $report->deadline_balance = $report->early_balance + $report->apply;

        // Calculate credit
        $credit = $report->new_credit_status - $report->deadline_balance;
        $report->credit = $credit;

        // Save the updated report
        $report->save();
    }
}
