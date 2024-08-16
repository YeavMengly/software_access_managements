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
        $sortField = $request->input('sort_field', 'name_certificate'); // Default sort field
        $sortDirection = $request->input('sort_direction', 'asc'); // Default sort direction

        // Ensure the sort field is a valid column in your table
        if (!in_array($sortField, ['name_certificate', 'value_certificate', 'other_valid_column'])) {
            $sortField = 'name_certificate'; // Fallback to default if invalid
        }

        // Fetch certificate data with an optional search filter and sorting
        $certificatesData = CertificateData::with('certificate')
            ->when($search, function ($query, $search) {
                return $query->whereHas('certificate', function ($query) use ($search) {
                    $query->where('name_certificate', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate(10);

        return view('layouts.admin.forms.certificate.certificate-data-index', compact('certificatesData'));
    }


    public function create()
    {
        // import model
        $keys = Key::all();
        $accountKeys = AccountKey::all();
        $subAccountKeys = SubAccountKey::all();

        $reports = Report::all();

        $certificates = Certificate::all();


        return view('layouts.admin.forms.certificate.certificate-data-create', compact('certificates', 'reports', 'subAccountKeys', 'accountKeys', 'keys'));
    }

    public function store(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'name_certificate' => 'required|exists:certificates,id',
            'value_certificate' => 'required|numeric',
        ]);

        // Fetch the related report and certificate
        $report = Report::findOrFail($validated['report_key']);
        $certificate = Certificate::findOrFail($validated['name_certificate']);

        // Retrieve the related sub-account key and account key
        $subAccountKey = SubAccountKey::where('id', $report->sub_account_key)->first();
        $accountKey = AccountKey::where('id', $subAccountKey->account_key)->first();

        // Calculate the new total for value_certificate based on matching code, account_key, and sub_account_key
        $newApplyTotal = CertificateData::whereHas('report.subAccountKey.accountKey.key', function ($query) use ($accountKey) {
            $query->where('code', $accountKey->key->code);
        })
            ->where('name_certificate', $validated['name_certificate'])
            ->where('report_key', '<>', $validated['report_key']) // Exclude the current report_key
            ->sum('value_certificate');

        $newApplyTotal += $validated['value_certificate']; // Add the current value_certificate to the total

        // Update the apply field in the report
        $report->update(['apply' => $newApplyTotal]);

        // Create the certificate data
        CertificateData::create([
            'report_key' => $validated['report_key'],
            'name_certificate' => $validated['name_certificate'],
            'value_certificate' => $validated['value_certificate'],
            'amount' => $newApplyTotal,
        ]);

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
        return view('certificate-data.edit', compact('certificateData', 'certificates'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'certificate_id' => 'required',
            'value_certificate' => 'required|numeric',
        ]);
        $certificateData = CertificateData::findOrFail($id);
        $certificateData->update($validated);
        return redirect()->route('certificate-data.index')->with('success', 'Certificate data updated successfully.');
    }

    public function destroy($id)
    {
        // Find the CertificateData record
        $certificateData = CertificateData::findOrFail($id);

        // Get the related report
        $report = Report::findOrFail($certificateData->report_key);

        // Delete the CertificateData record
        $certificateData->delete();

        // Recalculate the total value_certificate for the report
        $newApplyTotal = CertificateData::where('report_key', $report->id)->sum('value_certificate');

        // Update the apply field in the report
        // If there are no remaining certificate data records, set apply to null or 0
        $report->apply = $newApplyTotal > 0 ? $newApplyTotal : null; // or set to 0 instead of null if needed
        $report->save();

        return redirect()->route('certificate-data.index')->with('success', 'Certificate data deleted successfully.');
    }
}
