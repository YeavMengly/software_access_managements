<?php

namespace App\Http\Controllers\Mandates;

use App\Http\Controllers\Controller;
use App\Models\Code\Report;

class ResultFMCController extends Controller
{
    public function index()
    {
        // Eager-load related models
        $reports = Report::with(['certificateData', 'mandate', 'subAccountKey', 'dataMandate'])->get();
         

        // Merge Report and DataMandate models into a new collection
        $mergedReports = $reports->map(function ($report) {
            return (object) [
                'sub_account_key' => $report->subAccountKey->sub_account_key ?? 'N/A',
                'report_key' => $report->report_key,
                'fin_law' => $report->fin_law,
                'value_certificate' => $report->apply - $report->credit   ?? 'គ្មានទិន្នន័យ',
                'value_mandate' => $report->dataMandate->first()?->deadline_balance ?? 'គ្មានទិន្នន័យ',

            ];
        });
        

        return view('layouts.table.fmc.result-fin-mandate-certificate', compact('mergedReports'));
    }
}
