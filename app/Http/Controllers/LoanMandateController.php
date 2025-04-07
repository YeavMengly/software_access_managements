<?php

namespace App\Http\Controllers;

use App\Models\DataMandate;
use App\Models\LoanMandate;
use App\Models\Mandates\Mandate;
use Illuminate\Http\Request;

class LoanMandateController extends Controller
{
    public function index(Request $request)
    {
        $subAccountKeyId = $request->input('sub_account_key_id');
        $reportKey = $request->input('report_key');
        $perPage = $request->input('per_page', 25);

        $query = LoanMandate::query();

        // Filter by Sub-Account Key
        if ($subAccountKeyId) {
            $query->whereHas('subAccountKey', function ($q) use ($subAccountKeyId) {
                $q->where('sub_account_key_column_in_related_table', 'like', "%{$subAccountKeyId}%");
            });
        }

        // Filter by Report Key and Year Status
        if ($reportKey) {
            $query->whereHas('report', function ($q) use ($reportKey) {
                $q->where('report_key_column_in_related_table', 'like', "%{$reportKey}%")
                    ->whereHas('year', function ($q) {
                        $q->where('status', 'active');
                    });
            });
        } else {
            $query->whereHas('report.year', function ($q) {
                $q->where('status', 'active');
            });
        }

        // Paginate Results
        $loanMandates = $query->paginate($perPage);

        return view('layouts.admin.forms.loans.mandate.loan-mandate-index', compact('loanMandates'));
    }

    public function create()
    {

        $dataMandates = DataMandate::all();
        return view('layouts.admin.forms.loans.mandate.loan-mandate-create', compact('dataMandates'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'report_key' => ['required', 'exists:data_mandates,id'],
            'internal_increase' => 'nullable|numeric|min:0',
            'unexpected_increase' => 'nullable|numeric|min:0',
            'additional_increase' => 'nullable|numeric|min:0',
            'decrease' => 'nullable|numeric|min:0',
            'editorial' => 'nullable|numeric|min:0',
        ]);

        $validatedData['internal_increase'] = $validatedData['internal_increase'] ?? 0;
        $validatedData['unexpected_increase'] = $validatedData['unexpected_increase'] ?? 0;
        $validatedData['additional_increase'] = $validatedData['additional_increase'] ?? 0;
        $validatedData['decrease'] = $validatedData['decrease'] ?? 0;
        $validatedData['editorial'] = $validatedData['editorial'] ?? 0;

        // $existingReport = DataMandate::where('report_key', $validatedData['report_key'])->first();
        $existingReport = DataMandate::find($request->report_key);

        if (!$existingReport) {
            return redirect()->back()->withErrors([
                'report_key' => 'The selected report does not exist.'
            ])->withInput();
        }

        $current_loan = $existingReport->current_loan;
        $fin_law = $existingReport->fin_law;
        $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];
        $new_credit_status = $current_loan + $total_increase - $validatedData['decrease'] - $validatedData['editorial'];
        $currentApplyTotal = Mandate::where('report_key', $validatedData['report_key'])->sum('value_mandate');
        $deadline_balance = $currentApplyTotal;
        $credit = $new_credit_status - $deadline_balance;
        $law_average = $fin_law ? max(-100, min(100, ($deadline_balance / $fin_law) * 100)) : 0;
        $law_correction = $new_credit_status ? max(-100, min(100, ($deadline_balance / $new_credit_status) * 100)) : 0;

        LoanMandate::create([
            ...$validatedData,
            'total_increase' => $total_increase,
        ]);


        $existingReport->update([
            'new_credit_status' => $new_credit_status,
            'apply' => $currentApplyTotal,
            'deadline_balance' => $deadline_balance,
            'credit' => $credit,
            'law_average' => $law_average,
            'law_correction' => $law_correction,
            'current_loan' => $current_loan,
        ]);
        return redirect()->route('loan-mandates.index')->with('success', 'Loan transaction added successfully!');
    }

    public function edit($id)
    {
        $loanMandate = LoanMandate::findOrFail($id);
        $dataMandates = DataMandate::all();
        return view('layouts.admin.forms.loans.mandate.loan-mandate-edit', compact('loanMandate', 'dataMandates'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'report_key' => ['required', 'exists:data_mandates,id'],
            'internal_increase' => 'nullable|numeric|min:0',
            'unexpected_increase' => 'nullable|numeric|min:0',
            'additional_increase' => 'nullable|numeric|min:0',
            'decrease' => 'nullable|numeric|min:0',
            'editorial' => 'nullable|numeric|min:0',
        ]);

        $validatedData = array_map(fn($value) => $value ?? 0, $validatedData);

        $loanMandate = LoanMandate::findOrFail($id);
        $existingReport = DataMandate::find($validatedData['report_key']);

        $current_loan = $existingReport->current_loan;
        $fin_law = $existingReport->fin_law;
        $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];
        $new_credit_status = $current_loan + $total_increase - $validatedData['decrease'] - $validatedData['editorial'];
        $currentApplyTotal = Mandate::where('report_key', $validatedData['report_key'])->sum('value_mandate');
        $deadline_balance = $currentApplyTotal;
        $credit = $new_credit_status - $deadline_balance;
        $law_average = $fin_law ? max(-100, min(100, ($deadline_balance / $fin_law) * 100)) : 0;
        $law_correction = $new_credit_status ? max(-100, min(100, ($deadline_balance / $new_credit_status) * 100)) : 0;

        $loanMandate->update([
            ...$validatedData,
            'total_increase' => $total_increase,
        ]);

        $existingReport->update([
            'new_credit_status' => $new_credit_status,
            'apply' => $currentApplyTotal,
            'deadline_balance' => $deadline_balance,
            'credit' => $credit,
            'law_average' => $law_average,
            'law_correction' => $law_correction,
            'current_loan' => $current_loan,
        ]);

        return redirect()->route('loan-mandates.index')->with('success', 'ការបញ្ជាក់ការឥណទានត្រូវបានអាប់ដេតដោយជោគជ័យ!');
    }


    public function destroy($id)
    {
        $loanMandate = LoanMandate::findOrFail($id);
        $dataMandates = DataMandate::find($loanMandate->report_key);

        if ($dataMandates) {

            $total_increase = $loanMandate->internal_increase + $loanMandate->unexpected_increase + $loanMandate->additional_increase;
            $new_credit_status = $dataMandates->new_credit_status - $total_increase + $dataMandates->decrease + $dataMandates->editorial;
            $currentApplyTotal = Mandate::where('report_key', $dataMandates->id)->sum('value_mandate');

            $deadline_balance = $currentApplyTotal;
            $credit = $new_credit_status - $deadline_balance;
            $law_average = $dataMandates->fin_law ? max(-100, min(100, ($deadline_balance / $dataMandates->fin_law) * 100)) : 0;
            $law_correction = $new_credit_status ? max(-100, min(100, ($deadline_balance / $new_credit_status) * 100)) : 0;
            $dataMandates->update([
                'new_credit_status' => $new_credit_status,
                'apply' => $currentApplyTotal,
                'deadline_balance' => $deadline_balance,
                'credit' => $credit,
                'law_average' => $law_average,
                'law_correction' => $law_correction,
            ]);
        }
        $loanMandate->delete();

        return redirect()->route('loan-mandates.index')->with('success', 'ចលនាឥណទានបានលុបដោយជោគជ័យ។');
    }
}
