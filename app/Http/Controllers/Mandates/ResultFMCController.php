<?php

namespace App\Http\Controllers\Mandates;

use App\Http\Controllers\Controller;
use App\Models\Code\Report;

class ResultFMCController extends Controller
{
    public function index()
    {

        $reports = Report::with(['certificateData', 'mandate', 'subAccountKey', 'dataMandate'])->get();

        $mergedReports = $reports->map(function ($report) {
            return (object) [
                'sub_account_key' => $report->subAccountKey->sub_account_key ?? 'គ្មានទិន្នន័យ',
                'report_key' => $report->report_key,
                'fin_law' => number_format($report->fin_law, 0, ' ', ' '),
                'new_credit_status' => number_format($report->new_credit_status, 0, ' ', ' '),
                'value_certificate' => isset($report->new_credit_status, $report->apply)
                    ? number_format($report->new_credit_status - $report->deadline_balance, 0, ' ', ' ')
                    : 'គ្មានទិន្នន័យ',
                'value_mandate' => isset(optional($report->dataMandate->first())->new_credit_status , optional($report->dataMandate->first())->apply)
                    ? number_format(
                        $report->dataMandate->first()->new_credit_status - $report->dataMandate->first()->deadline_balance,
                        0,
                        ' ',
                        ' '
                    )
                    : 'គ្មានទិន្នន័យ',
            ];
        });

        return view('layouts.table.fmc.result-fin-mandate-certificate', compact('mergedReports'));
    }
}
