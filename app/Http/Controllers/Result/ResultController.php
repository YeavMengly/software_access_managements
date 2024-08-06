<?php

namespace App\Http\Controllers\Result;

use App\Exports\Results\ResultExport;
use App\Http\Controllers\Controller;
use App\Models\Code\Report;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::query();

        // Date filtering with error handling
        $date = $request->input('date');
        if ($date) {
            try {
                $formattedDate = Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d');
                $query->whereDate('date', $formattedDate);
            } catch (\Exception $e) {
                return back()->withErrors(['date' => 'Invalid date format. Please use MM/DD/YYYY.']);
            }
        }

        // Apply filters
        $this->applyFilters($query, $request);

        $reports = $query->get();

        // Calculate the totals
        $totals = $this->calculateTotals($reports);

        return view('layouts.table.result', [
            'reports' => $reports,
            'totals' => $totals,
        ]);
    }

    public function export(Request $request)
    {
        $query = Report::query();

        // Apply filters
        $this->applyFilters($query, $request);

        // Get the filtered reports
        $reports = $query->get();
        return Excel::download(new ResultExport($reports), 'results.xlsx');
    }

    private function applyFilters($query, $request)
    {
        if ($request->has('code_id') && $request->input('code_id') != '') {
            $query->whereHas('subAccountKey.accountKey.key', function ($q) use ($request) {
                $q->where('code', 'like', '%' . $request->input('code_id') . '%');
            });
        }

        if ($request->has('account_key_id') && $request->input('account_key_id') != '') {
            $query->whereHas('subAccountKey.accountKey', function ($q) use ($request) {
                $q->where('account_key', 'like', '%' . $request->input('account_key_id') . '%');
            });
        }

        if ($request->has('sub_account_key_id') && $request->input('sub_account_key_id') != '') {
            $query->whereHas('subAccountKey', function ($q) use ($request) {
                $q->where('sub_account_key', 'like', '%' . $request->input('sub_account_key_id') . '%');
            });
        }

        if ($request->has('report_key') && $request->input('report_key') != '') {
            $query->where('report_key', 'like', '%' . $request->input('report_key') . '%');
        }
    }

    private function calculateTotals($reports)
    {
        return [
            'internal_increase' => $reports->sum('internal_increase'),
            'unexpected_increase' => $reports->sum('unexpected_increase'),
            'additional_increase' => $reports->sum('additional_increase'),
            'decrease' => $reports->sum('decrease'),
            'total_increase' => $reports->sum(function ($report) {
                return $report->internal_increase + $report->unexpected_increase + $report->additional_increase;
            }),
            'total_balance' => $reports->sum(function ($report) {
                return ($report->internal_increase + $report->unexpected_increase + $report->additional_increase) - $report->decrease;
            }),
        ];
    }
}
