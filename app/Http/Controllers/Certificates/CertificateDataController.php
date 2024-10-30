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
        // $certificate = Certificate::findOrFail($validated['name_certificate']);

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

        $oldReport->new_credit_status = $oldReport->new_credit_status + $oldApply;
        $oldReport->apply = $oldReport->apply - $oldApply;
        $oldReport->deadline_balance = $oldReport->deadline_balance - $oldApply;
        $oldReport->save();
        $certificateData->value_certificate = $validated['value_certificate'];
        $certificateData->report_key = $validated['report_key'];
        $certificateData->save();

        // Recalculate and save report values
        $this->recalculateAndSaveReport($report);

        return redirect()->route('certificate-data.index')->with('success', 'Certificate data updated successfully.');
    }


    public function destroy($id)
    {
        $certificateData = CertificateData::findOrFail($id);
        $report = Report::findOrFail($certificateData->report_key);

        $certificateData->delete();
        // Set default values for nullable fields if not provided
        $validatedData['internal_increase'] = $validatedData['internal_increase'] ?? 0;
        $validatedData['unexpected_increase'] = $validatedData['unexpected_increase'] ?? 0;
        $validatedData['additional_increase'] = $validatedData['additional_increase'] ?? 0;
        $validatedData['decrease'] = $validatedData['decrease'] ?? 0;
        $validatedData['editorial'] = $validatedData['editorial'] ?? 0;

        $current_loan = $report->current_loan;

        // Calculate total_increase
        $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];

        // Calculate new_credit_status
        $new_credit_status = $current_loan + $total_increase - $validatedData['decrease'] - $validatedData['editorial'];

        // Recalculate the total value_certificate for the report
        $newApplyTotal = CertificateData::where('report_key', $report->id)->sum('value_certificate');
        $report->apply = $newApplyTotal > 0 ? $newApplyTotal : 0;
        $report->deadline_balance = $report->early_balance + $report->apply;
        $credit = $new_credit_status -  $report->deadline_balance;
        $report->update([
            $credit
        ]);
        $report->save();
        $this->recalculateAndSaveReport($report);
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
<<<<<<< HEAD


=======
>>>>>>> 307b6364ea92696bcd64cc9dd0662a50e8c237bd
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
<<<<<<< HEAD
        // Save the updated report
=======
>>>>>>> 307b6364ea92696bcd64cc9dd0662a50e8c237bd
        $report->save();
    }
}
