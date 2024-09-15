<?php

namespace App\Http\Controllers\Loans;

use App\Http\Controllers\Controller;
use App\Models\Code\Report;
use Illuminate\Http\Request;

class NewLoanController extends Controller
{
    //
   public function index()
{
    // Fetch reports with necessary relationships and sort by `code`
    $reports = Report::with('subAccountKey.accountKey.key')
        ->get()
        ->sortBy(function ($report) {
            return $report->subAccountKey->accountKey->key->code;
        });

    return view('layouts.table.loan_total.result-new-loan', compact('reports'));
}

}
