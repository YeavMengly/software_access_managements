<?php

namespace App\Http\Controllers\Mandates;

use App\Http\Controllers\Controller;
use App\Models\Code\Report;

class ResultFMCController extends Controller
{
    public function index()
    {

        $reports = Report::with(['certificateData', 'mandates', 'subAccountKey', 'dataMandates'])->get();

        $mergedReports = $reports->map(function ($report) {
            return (object) [
                'sub_account_key' => $report->subAccountKey->sub_account_key ?? 'គ្មានទិន្នន័យ',
                'report_key' => $report->report_key,
                'fin_law' => number_format($report->fin_law, 0, ' ', ' '),
                'value_certificate' => isset($report->new_credit_status, $report->apply)
                    ? number_format($report->new_credit_status - $report->deadline_balance, 0, ' ', ' ')
                    : 'គ្មានទិន្នន័យ',
                'value_mandate' => optional($report->dataMandates->first())->apply && optional($report->dataMandates->first())->new_credit_status
                    ? number_format(
                        $report->dataMandates->first()->new_credit_status - $report->dataMandates->first()->deadline_balance,
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
