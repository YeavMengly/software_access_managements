<?php

namespace App\Http\Controllers\Certificates;

use App\Http\Controllers\Controller;
use App\Models\Certificates\Certificate;
use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 25);

        // Get sort parameters with default values
        $sortField = $request->input('sort_field', 'early_balance'); // Default sort field
        $sortDirection = $request->input('sort_direction', 'asc'); // Default sorting direction

        $certificates = Certificate::when($search, function ($query, $search) {
            return $query->where('early_balance', 'like', "%{$search}%");
        })
            ->orderBy($sortField, $sortDirection) // Apply sorting
            ->paginate($perPage);

        return view('layouts.admin.forms.certificate.certificate-index', compact('certificates', 'sortField', 'sortDirection'));
    }


    public function create()
    {
        $subAccountKeys = SubAccountKey::all();
        $reports = Report::all();
        return view('layouts.admin.forms.certificate.certificate-create', compact('reports', 'subAccountKeys',));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'early_balance' => 'required|numeric'
        ], );

        // Find the report with the provided report_key
        $report = Report::findOrFail($validated['report_key']);

        // Check if the report has a valid subAccountKey relationship
        if (!$report || !$report->subAccountKey) {
            return redirect()->back()->withErrors(['error' => 'Invalid report or sub-account key.']);
        }

        // Create a new Certificate with the provided early_balance
        Certificate::create([
            'report_key' => $validated['report_key'],
            'early_balance' => $validated['early_balance']
        ]);

        // Recalculate and update the early_balance in the report
        $this->recalculateAndSaveReport($report);

        return redirect()->route('certificate.store')->with('success', 'ឈ្មោះសលាកបត្របានដោយជោគជ័យ');
    }


    public function show($id)
    {
        $certificate = Certificate::findOrFail($id);
        return view('certificate.show', compact('certificate'));
    }

    public function edit($id)
    {
        $certificates = Certificate::findOrFail($id);
        $reports = Report::all();
        $subAccountKeys = SubAccountKey::all();
        return view('layouts.admin.forms.certificate.certificate-edit', compact('certificates', 'reports', 'subAccountKeys'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'early_balance' => 'required'
        ]);
        $certificates = Certificate::findOrFail($id);
        $certificates->update($validated);
        return redirect()->route('certificate.index')->with('success', 'ឈ្មោះសលាកបត្របានកែដោយជោគជ័យ');
    }

    public function destroy($id)
    {
        // Find the certificate record by ID
        $certificate = Certificate::findOrFail($id);
        $report = $certificate->report;

        // Delete the certificate record
        $certificate->delete();

        // Check if a report is associated before recalculating
        if ($report) {
            $this->recalculateAndSaveReport($report);
        }

        return redirect()->route('certificate.index')->with('success', 'បានលុបទិន្នន័យដោយជោគជ័យ');
    }

    private function recalculateAndSaveReport(Report $report)
    {
        // Sum the numeric values of early_balance for all Certificates associated with this report
        $early_balance_total = Certificate::where('report_key', $report->id)
            ->get()
            ->sum(fn($certificate) => (float) $certificate->early_balance);

        // Assign the calculated total to the report's early_balance field
        $report->early_balance = $early_balance_total;

        // Ensure `apply` and other fields are numeric; default to 0 if null
        $apply = $report->apply ?? 0;
        $new_credit_status = $report->new_credit_status ?? 0;
        $fin_law = $report->fin_law ?? 0;

        // Calculate deadline_balance and credit
        $report->deadline_balance = $early_balance_total + $apply;
        $report->credit = $new_credit_status - $report->deadline_balance;

        // Calculate law_average and law_correction safely
        $report->law_average = $fin_law > 0 ? ($report->deadline_balance / $fin_law) * 100 : 0;
        $report->law_correction = $new_credit_status > 0 ? ($report->deadline_balance / $new_credit_status) * 100 : 0;

        // Save the updated report
        $report->save();
    }
}
