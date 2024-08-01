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


    // // Show the form for creating a new resource
    public function create()
    {
        $subAccountKeys = SubAccountKey::all();
        return view('layouts.admin.forms.code.report-create', compact('subAccountKeys'));
    }

    // // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'sub_account_key_id' => 'required|exists:sub_account_keys,id',
            'report_key' => 'required|string|max:255',
            'name_report_key' => 'required|string|max:255',
            'fin_law' => 'required|numeric',
            'current_loan' => 'required|numeric',
            'internal_increase' => 'required|numeric',
            'unexpected_increase' => 'required|numeric',
            'additional_increase' => 'required|numeric',
            'decrease' => 'required|numeric',
        ]);

        // Calculate the total increase and total balance
        $totalIncrease = $request->input('internal_increase') + $request->input('unexpected_increase') + $request->input('additional_increase');
        $totalBalance = $totalIncrease - $request->input('decrease');

        Report::create([
            'sub_account_key_id' => $request->input('sub_account_key_id'),
            'report_key' => $request->input('report_key'),
            'name_report_key' => $request->input('name_report_key'),
            'fin_law' => $request->input('fin_law'),
            'current_loan' => $request->input('current_loan'),
            'internal_increase' => $request->input('internal_increase'),
            'unexpected_increase' => $request->input('unexpected_increase'),
            'additional_increase' => $request->input('additional_increase'),
            'decrease' => $request->input('decrease'),
            'total_increase' => $totalIncrease,
            'total_balance' => $totalBalance,
        ]);

        return redirect()->route('codes.index')->with('success', 'Report Key created successfully.');
    }

    // // Display the specified resource
    // public function show($id)
    // {
    //     $reportKey = Report::findOrFail($id);
    //     return view('report_keys.show', compact('reportKey'));
    // }

    // // Show the form for editing the specified resource
    // public function edit($id)
    // {
    //     $reportKey = Report::findOrFail($id);
    //     $subAccountKeys = SubAccountKey::all();
    //     return view('report_keys.edit', compact('reportKey', 'subAccountKeys'));
    // }

    // // Update the specified resource in storage
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'sub_account_key_id' => 'required|exists:sub_account_keys,id',
    //         'report_key' => 'required|string|max:255',
    //         'name_report_key' => 'required|string|max:255',
    //         'fin_law' => 'required|numeric',
    //         'current_loan' => 'required|numeric',
    //         'internal_increase' => 'required|numeric',
    //         'unexpected_increase' => 'required|numeric',
    //         'additional_increase' => 'required|numeric',
    //         'decrease' => 'required|numeric',
    //     ]);

    //     $reportKey = Report::findOrFail($id);
    //     $reportKey->update($request->all());

    //     return redirect()->route('report_keys.index')->with('success', 'Report Key updated successfully.');
    // }

    // // Remove the specified resource from storage
    public function destroy($id)
    {
        $reportKey = Report::findOrFail($id);
        $reportKey->delete();

        return redirect()->route('codes.index')->with('success', 'Report Key deleted successfully.');
    }
}
