<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Create varriable
        $search = $request->input('search');
        $section = $request->input('code_id');
        $account = $request->input('account_key_id');
        $subAccount = $request->input('sub_account_key_id');
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


    // Show the form for creating a new resource
    public function create()
    {
        $subAccountKeys = SubAccountKey::all();
        return view('layouts.admin.forms.code.report-create', compact('subAccountKeys'));
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sub_account_key_id' => 'required|exists:sub_account_keys,id',
            'report_key' => 'required|string|max:255',
            'name_report_key' => 'required|string|max:255',
            'fin_law' => 'required|numeric',
            'current_loan' => 'required|numeric',
            'internal_increase' => 'required|numeric',
            'unexpected_increase' => 'required|numeric',
            'additional_increase' => 'required|numeric',
            // 'total_increase', get value
            'decrease' => 'required|numeric',
            // 'editorial' => 'required|numeric',
            // 'new_credit_status'  get value
            // 'early_balance' => 'required|numeric',
            // 'apply' => 'required|numeric',
            // 'deadline_balance',
            // 'credit',
            // 'law_average',
            // 'law_correction'
        ]);

        // Calculate totals
        $total_increase = $validatedData['internal_increase'] + $validatedData['unexpected_increase'] + $validatedData['additional_increase'];

        // $editorial = $validatedData['editorial'];

        $new_credit_status = $validatedData['current_loan'] + $total_increase - $validatedData['decrease'];

        $apply = 10;

        // $deadline_balance = $validatedData['early_balance'] + $validatedData['apply'];

        // $credit =  $new_credit_status -  $deadline_balance;

        // Find value of average
        // $lawAverage = $validatedData['fin_law'] /  $deadline_balance;
        // $lawCorrection =  $new_credit_status / $deadline_balance;

        // Create the report
        Report::create([
            ...$validatedData,
            'total_increase' => $total_increase,
            // 'editorial' => $editorial,
            'new_credit_status' => $new_credit_status,
            // 'early_balance' => $earlyBalance,
            'apply' => $apply,
            // 'deadline_balance' => $deadline_balance,
            // 'credit' => $credit,
            // 'law_average' => $lawAverage,
            // 'law_correction' => $lawCorrection
        ]);

        return redirect()->route('codes.index')->with('success', 'Report Key created successfully.');
    }

    // // Remove the specified resource from storage
    public function destroy($id)
    {
        $reportKey = Report::findOrFail($id);
        $reportKey->delete();

        return redirect()->route('codes.index')->with('success', 'Report Key deleted successfully.');
    }
}
