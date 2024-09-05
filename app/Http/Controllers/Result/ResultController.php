<?php

namespace App\Http\Controllers\Result;

use App\Exports\Results\ResultExport;
use App\Http\Controllers\Controller;
use App\Models\Code\Report;
use Barryvdh\DomPDF\Facade\Pdf;
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

    // PDF Print
    public function exportPdf(Request $request)
    {
        try {
            $query = Report::query();

            // Apply filters
            $this->applyFilters($query, $request);

            // Get the filtered reports
            $reports = $query->get();

            $pdf = Pdf::loadView('layouts.pdf.result_pdf', [
                'reports' => $reports,
                'totals' => $this->calculateTotals($reports),
            ]);

            // Set the PDF orientation to landscape with A4 size and custom margins
            $pdf->setPaper('a2', 'landscape')
                ->setOption('zoom', '85%')
                ->setOptions([
                    'margin-top' => 5,
                    'margin-bottom' => 5,
                    'margin-left' => 0,
                    'margin-right' => 5,
                ]);

            // Return the generated PDF
            return $pdf->download('results.pdf');
        } catch (\Exception $e) {
            // Log or display the error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    private function applyFilters($query, $request)
{
    if ($request->has('code_id') && $request->input('code_id') !== '') {
        $firstTwoDigits = substr($request->input('code_id'), 0, 2);
        $query->whereHas('subAccountKey.accountKey.key', function ($q) use ($firstTwoDigits) {
            $q->where('code', 'like', $firstTwoDigits . '%');
        });
    }

    if ($request->has('account_key_id') && $request->input('account_key_id') !== '') {
        $firstFourDigits = substr($request->input('account_key_id'), 0, 4);
        $query->whereHas('subAccountKey.accountKey', function ($q) use ($firstFourDigits) {
            $q->where('account_key', 'like', $firstFourDigits . '%');
        });
    }

    if ($request->has('sub_account_key_id') && $request->input('sub_account_key_id') !== '') {
        $firstFiveDigits = substr($request->input('sub_account_key_id'), 0, 5);
        $query->whereHas('subAccountKey', function ($q) use ($firstFiveDigits) {
            $q->where('sub_account_key', 'like', $firstFiveDigits . '%');
        });
    }

    if ($request->has('report_key') && $request->input('report_key') !== '') {
        $firstSevenDigits = substr($request->input('report_key'), 0, 7);
        $query->where('report_key', 'like', $firstSevenDigits . '%');
    }

    return $query; // Ensure the modified query is returned
}


    private function calculateTotals($reports)
    {
        return [
            'internal_increase' => $reports->sum('internal_increase'),
            'unexpected_increase' => $reports->sum('unexpected_increase'),
            'additional_increase' => $reports->sum('additional_increase'),
            'decrease' => $reports->sum('decrease'),
            'apply' => $reports->sum('apply'),
            'total_increase' => $reports->sum(function ($report) {
                return $report->internal_increase + $report->unexpected_increase + $report->additional_increase;
            }),
            'total_balance' => $reports->sum(function ($report) {
                return ($report->internal_increase + $report->unexpected_increase + $report->additional_increase) - $report->decrease;
            }),
        ];
    }
}
