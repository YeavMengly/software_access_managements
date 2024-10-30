<?php

namespace App\Http\Controllers\Certificates;

use App\Http\Controllers\Controller;
use App\Models\Certificates\Certificate;
use App\Models\Certificates\CertificateData;
use App\Models\Code\AccountKey;
use App\Models\Code\Key;
use App\Models\Code\Loans;
use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use Illuminate\Http\Request;

class CertificateDataController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortField = $request->input('sort_field', 'value_certificate'); // Default to a valid column
        $sortDirection = $request->input('sort_direction', 'asc');
        $perPage = $request->input('per_page', 25);

        // Ensure the sort field is valid
        if (!in_array($sortField, ['value_certificate', 'report_key'])) {
            $sortField = 'value_certificate'; // Default to a valid column
        }

        // Fetch certificate data with search by report_key and sorting
        $certificatesData = CertificateData::with(['report.subAccountKey.accountKey.key'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('report', function ($query) use ($search) {
                    return $query->where('report_key', 'like', "%{$search}%"); // Search by report_key
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

        return view('layouts.admin.forms.certificate.certificate-data-create', compact('reports', 'subAccountKeys', 'accountKeys', 'keys'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'value_certificate' => 'required|numeric',
        ]);

        $report = Report::findOrFail($validated['report_key']);

        if (!$report || !$report->subAccountKey) {
            return redirect()->back()->withErrors(['error' => 'Invalid report or sub-account key.']);
        }

        CertificateData::create([
            'report_key' => $validated['report_key'],
            // 'name_certificate' => $validated['name_certificate'],
            'value_certificate' => $validated['value_certificate'],
        ]);
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
        $reports = Report::all();
        $subAccountKeys = SubAccountKey::all();

        return view('layouts.admin.forms.certificate.certificate-data-edit', compact('certificateData', 'reports', 'subAccountKeys'));
    }



    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'value_certificate' => 'required|numeric',
        ]);



        $certificateData = CertificateData::findOrFail($id);
        $report = Report::find($validated['report_key']);
        $oldReport = $certificateData->report;
        $oldApply = $certificateData->value_certificate;
    


        if (empty($report)) {
            return redirect()->route('certificate-data.index')->with('error', 'SubAccountKey not found for the selected report.');
        }
     }
}