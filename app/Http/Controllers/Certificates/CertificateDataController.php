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
        $sortField = $request->input('sort_field', 'value_certificate'); // Default to another valid column
        $sortDirection = $request->input('sort_direction', 'asc');
        $perPage = $request->input('per_page', 25);

        // Ensure the sort field is valid
        if (!in_array($sortField, ['value_certificate', 'other_valid_column'])) {
            $sortField = 'value_certificate'; // Default to a valid column
        }

        // Fetch certificate data with an optional search filter and sorting
        $certificatesData = CertificateData::with(['certificate', 'report.subAccountKey.accountKey.key'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('certificate', function ($query) use ($search) {
                    // Remove name_certificate search, or change it to a valid field
                    return $query->where('other_valid_column', 'like', "%{$search}%"); // Change this to a valid column if necessary
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

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'report_key' => 'required|exists:reports,id',
    //         'name_certificate' => 'required|exists:certificates,id',
    //         'value_certificate' => 'required|numeric',
    //     ]);

    //     // Retrieve or create a Loans record for the given report_key
    //     $loans = Loans::where('report_key', $validated['report_key'])->first();

    //     // If no Loans found, create a new one
    //     if (empty($loans)) {
    //         $loans = new Loans();
    //         $loans->report_key = $validated['report_key']; // Ensure the report_key is assigned
    //         $loans->early_balance = 0; // You may need to set an initial early_balance
    //         $loans->apply = 0; // Initialize apply or set it based on your logic
    //         $loans->deadline_balance = 0; // Initialize deadline_balance
    //         $loans->new_credit_status = 0; // Initialize new_credit_status if applicable
    //         // Save the new loans record before proceeding
    //         $loans->save();
    //     }

    //     // Check for uniqueness of name_certificate within the same report_key
    //     $existingCertificateData = CertificateData::where('report_key', $validated['report_key'])
    //         ->where('name_certificate', $validated['name_certificate'])
    //         ->first();

    //     if ($existingCertificateData) {
    //         return redirect()->back()->withErrors(['name_certificate' => 'The name_certificate must be unique within the same report.'])->withInput();
    //     }

    //     // Create the certificate data
    //     CertificateData::create([
    //         'report_key' => $validated['report_key'],
    //         'name_certificate' => $validated['name_certificate'],
    //         'value_certificate' => $validated['value_certificate'],
    //     ]);

    //     // Recalculate and save report values
    //     $this->recalculateAndSaveReport($loans);

    //     return redirect()->route('certificate-data.index')->with('success', 'Certificate data created successfully.');
    // }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_key' => 'required|exists:reports,id',
            // 'name_certificate' => 'required|exists:certificates,id',
            'value_certificate' => 'required|numeric',
        ]);

        $report = Report::findOrFail($validated['report_key']);
        // $certificate = Certificate::findOrFail($validated['name_certificate']);

        if (!$report || !$report->subAccountKey) {
            return redirect()->back()->withErrors(['error' => 'Invalid report or sub-account key.']);
        }

        // Check for uniqueness of name_certificate within the same report_key
        // $existingCertificateData = CertificateData::where('report_key', $validated['report_key'])
        //     // ->where('name_certificate', $validated['name_certificate'])
        //     ->first();

        // if ($existingCertificateData) {
        //     return redirect()->back()->withErrors(['name_certificate' => 'The name_certificate must be unique within the same report.'])->withInput();
        // }

        // Create the certificate data
        CertificateData::create([
            'report_key' => $validated['report_key'],
            // 'name_certificate' => $validated['name_certificate'],
            'value_certificate' => $validated['value_certificate'],
        ]);

        // Recalculate and save report values
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



    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'name_certificate' => 'required|exists:certificates,id',
            'value_certificate' => 'required|numeric',
        ]);

        $certificateData = CertificateData::findOrFail($id);
        $loans = Loans::findOrFail($validated['report_key']);

        if (!$loans->subAccountKey) {
            return redirect()->route('certificate-data.index')->with('error', 'SubAccountKey not found for the selected report.');
        }

        $certificateData->update([
            'report_key' => $validated['report_key'],
            'name_certificate' => $validated['name_certificate'],
            'value_certificate' => $validated['value_certificate'],
        ]);

        // Recalculate and save report values
        $this->recalculateAndSaveReport($loans);

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

<<<<<<< HEAD
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
=======
        // Save the updated report
>>>>>>> 9a3f69cf7c85d1c6420fef57cd823cf1eebbb0ed
        $report->save();
    }
}
