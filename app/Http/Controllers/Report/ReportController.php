<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Certificates\CertificateData;
use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Create variables
        $search = $request->input('search');
        $section = $request->input('code');
        $account = $request->input('account_key');
        $subAccount = $request->input('sub_account_key');
        $programCode = $request->input('report_key');
        $query = Report::query();

        // Apply filters
        if ($section) {
            $query->whereHas('subAccountKey.accountKey.key', function ($q) use ($section) {
                $q->where('code', 'like', "%$section%");
            });
        }

        if ($account) {
            $query->whereHas('subAccountKey.accountKey', function ($q) use ($account) {
                $q->where('account_key', 'like', "%$account%");
            });
        }

        if ($subAccount) {
            $query->whereHas('subAccountKey', function ($q) use ($subAccount) {
                $q->where('sub_account_key', 'like', "%$subAccount%");
            });
        }

        if ($programCode) {
            $query->where('report_key', 'like', "%$programCode%");
        }

        // Apply search condition
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('report_key', 'like', "%$search%")
                    ->orWhere('name_report_key', 'like', "%$search%");
            });
        }

        // Fetch the filtered and sorted data
        $reports = $query->get();

        return view('layouts.admin.forms.code.report-index', compact('reports'));
    }

    public function create()
    {
        $subAccountKeys = SubAccountKey::all();
        return view('layouts.admin.forms.code.report-create', compact('subAccountKeys'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sub_account_key' => 'required|exists:sub_account_keys,id',
            'report_key' => 'required|string|max:255',
            'name_report_key' => 'required|string|max:255',
            'fin_law' => 'required|numeric',
            'internal_increase' => 'nullable|numeric',
            'unexpected_increase' => 'nullable|numeric',
            'additional_increase' => 'nullable|numeric',
            'decrease' => 'nullable|numeric',
        ]);


        // Set 'decrease' to 0 if it's not provided
        $validatedData['internal_increase'] = $validatedData['internal_increase'] ?? 0;
        $validatedData['unexpected_increase'] = $validatedData['unexpected_increase'] ?? 0;
        $validatedData['additional_increase'] = $validatedData['additional_increase'] ?? 0;
        $validatedData['decrease'] = $validatedData['decrease'] ?? 0;

        // Set current_loan equal to fin_law
        $validatedData['current_loan'] = $validatedData['fin_law'];

        // Calculate totals
        $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];

        // Calculate new credit status
        $new_credit_status = $validatedData['current_loan'] + $total_increase - $validatedData['decrease'];

        // Check if a record with the same sub_account_key and report_key already exists
        $existingRecord = Report::where('sub_account_key', $request->input('sub_account_key'))
            ->where('report_key', $request->input('report_key'))
            ->first();

        if ($existingRecord) {
            return redirect()->back()->withErrors([
                'report_key' => 'The combination of Sub-Account Key ID and Report Key already exists.'
            ])->withInput();
        }

        // Get the current apply total for the report key
        $currentApplyTotal = CertificateData::where('report_key', $validatedData['report_key'])->sum('value_certificate');
        $newApplyTotal = $currentApplyTotal;

        // Create the new record
        Report::create([
            ...$validatedData,
            'total_increase' => $total_increase,
            'new_credit_status' => $new_credit_status,
            'apply' => $newApplyTotal,
        ]);

        return redirect()->route('codes.index')->with('success', 'ទិន្ន័យកម្មវិធីបានបង្កើតដោយជោគជ័យ។');
    }

    public function destroy($id)
    {
        $reportKey = Report::findOrFail($id);
        $reportKey->delete();

        return redirect()->route('codes.index')->with('success', 'Report Key deleted successfully.');
    }
}
