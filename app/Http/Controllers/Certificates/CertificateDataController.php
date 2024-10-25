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
        $perPage = $request->input('per_page', 5);

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
        // Fetch all necessary data 
        $keys = Key::all();
        $accountKeys = AccountKey::all();
        $subAccountKeys = SubAccountKey::all();
        $reports = Report::all();
        $certificates = Certificate::all();

        return view('layouts.admin.forms.certificate.certificate-data-create', compact('certificates', 'reports', 'subAccountKeys', 'accountKeys', 'keys'));
    }

    public function store(Request $request)
    {
        // Validate the request inputs
        $validated = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'name_certificate' => 'required|exists:certificates,id',
            'value_certificate' => 'required|numeric|min:0',
        ]);

        // Fetch report and certificate records
        $report = Report::findOrFail($validated['report_key']);
        $certificate = Certificate::findOrFail($validated['name_certificate']);

        // Ensure the report and sub-account key are valid
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

        // Create the certificate data entry
        $certificateData = CertificateData::create([
            'report_key' => $validated['report_key'],
            'name_certificate' => $validated['name_certificate'],
            'value_certificate' => $validated['value_certificate'],
        ]);

        // Recalculate and update report values
        $this->recalculateAndSaveReport($report);

        // Refresh the report to get the latest values
        $report->refresh();

        // Update the apply value to the last entered value_certificate
        $lastCertificateData = CertificateData::where('report_key', $validated['report_key'])->latest()->first();
        $report->apply = $lastCertificateData->value_certificate;

        // Update early_balance by recalculating it based on the new data
        // $report->early_balance = $this->calculateEarlyBalance($report) ?: 0;

        // Save the report with the updated apply and early_balance
        $report->save();

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

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'name_certificate' => 'required|exists:certificates,id',
            'value_certificate' => 'required|numeric|min:0',
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

        // Delete the certificate data
        $certificateData->delete();

        // Recalculate and update report values
        $this->recalculateAndSaveReport($report);

        return redirect()->route('certificate-data.index')->with('success', 'Certificate data deleted successfully.');
    }

    private function recalculateAndSaveReport(Report $report)
    {
        // Fetch all remaining certificate data for the given report_key
        $certificateData = CertificateData::where('report_key', $report->id)->get();

        // If there are certificates, get the last value for apply, otherwise set to 0
        if ($certificateData->isNotEmpty()) {
            $report->apply = $certificateData->last()->value_certificate;
        } else {
            $report->apply = 0; // Default to 0 if no certificates
        }

        // Recalculate early_balance
        $report->early_balance = $this->calculateEarlyBalance($report);

        // Recalculate deadline_balance and credit
        $report->deadline_balance = $report->early_balance - $report->apply;
        $report->credit = $report->new_credit_status - $report->deadline_balance;

        // Calculate law_average and law_correction
        $law_average = $report->deadline_balance > 0 ? ($report->deadline_balance / $report->fin_law) * 100 : 0;
        $law_correction =  $report->deadline_balance > 0 ? ($report->deadline_balance /  $report->new_credit_status) * 100 : 0;

        // Cap values between 0 and 100
        // $report->law_average = min(max($law_average, 0), 100);
        // $report->law_correction = min(max($law_correction, 0), 100);

        // Save updated report values
        $report->save();
    }

    private function calculateEarlyBalance($report)
    {
        // Fetch all certificate data for the given report_key
        $certificateData = CertificateData::where('report_key', $report->id)->get();

        // If there is only one record, early_balance should be 0
        if ($certificateData->count() === 1) {
            return 0;
        }

        // If there are multiple records, sum all values except the last one
        $totalEarlyBalance = $certificateData->slice(0, -1) // Exclude the last record
            ->filter(function ($item) {
                return !is_null($item->value_certificate) && $item->value_certificate !== '';
            })
            ->sum('value_certificate');

        // Return the calculated balance, or 0 if no valid certificates
        return $totalEarlyBalance ?: 0;
    }
}
