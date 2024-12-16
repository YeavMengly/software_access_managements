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

        $sortField = $request->input('sort_field', 'early_balance');
        $sortDirection = $request->input('sort_direction', 'asc');

        $certificates = Certificate::when($search, function ($query, $search) {
            return $query->where('early_balance', 'like', "%{$search}%");
        })
            ->whereHas('report.year', function ($query) {
                $query->where('status', 'active'); // Only include reports with an active year
            })
            ->orderBy($sortField, $sortDirection) // Apply sorting
            ->paginate($perPage);

        return view('layouts.admin.forms.certificate.certificate-index', compact('certificates', 'sortField', 'sortDirection'));
    }

    public function create()
    {
        $subAccountKeys = SubAccountKey::all();
        $reports = Report::whereHas('year', function ($query) {
            $query->where('status', 'active'); // Only include reports with an active year
        })->get();

        return view('layouts.admin.forms.certificate.certificate-create', compact('reports', 'subAccountKeys'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'early_balance' => 'required|numeric'
        ]);

        $report = Report::findOrFail($validated['report_key']);

        // Ensure the report's associated year is active
        if (!$report->year || $report->year->status !== 'active') {
            return redirect()->back()->withErrors(['error' => 'ឆ្នាំដែលទាក់ទងមិនសកម្មទេ។']);
        }

        // Ensure subAccountKey is associated
        if (!$report->subAccountKey) {
            return redirect()->back()->withErrors(['error' => 'មិនមានលេខអនុគណនី។']);
        }

        Certificate::create([
            'report_key' => $validated['report_key'],
            'early_balance' => $validated['early_balance']
        ]);

        $this->recalculateAndSaveReport($report);

        return redirect()->route('certificate.store')->with('success', 'ថវិការដើមគ្រាបានបញ្ជូលដោយជោគជ័យ។');
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

        return redirect()->route('certificate.index')->with('success', 'ថវិការដើមគ្រាបានកែដោយជោគជ័យ។');
    }

    public function destroy($id)
    {
        $certificate = Certificate::findOrFail($id);
        $report = $certificate->report;
        $certificate->delete();
        if ($report) {
            $this->recalculateAndSaveReport($report);
        }
        return redirect()->route('certificate.index')->with('success', 'ថវិការដើមគ្រាបានលុបដោយជោគជ័យ');
    }

    private function recalculateAndSaveReport(Report $report)
    {
        $early_balance_total = Certificate::where('report_key', $report->id)
            ->get()
            ->sum(fn($certificate) => (float) $certificate->early_balance);

        $report->early_balance = $early_balance_total;
        $apply = $report->apply ?? 0;
        $new_credit_status = $report->new_credit_status ?? 0;
        $fin_law = $report->fin_law ?? 0;

        $report->deadline_balance = $early_balance_total + $apply;
        $report->credit = $new_credit_status - $report->deadline_balance;

        $report->law_average = $fin_law > 0 ? ($report->deadline_balance / $fin_law) * 100 : 0;
        $report->law_correction = $new_credit_status > 0 ? ($report->deadline_balance / $new_credit_status) * 100 : 0;

        $report->save();
    }
}
