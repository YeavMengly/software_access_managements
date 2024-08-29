<?php

namespace App\Http\Controllers\Loans;

use App\Http\Controllers\Controller;
use App\Models\Code\Report;
use Illuminate\Http\Request;

class NewLoanController extends Controller
{
    //
    public function index(){
        $reports = Report::all();
        return view('layouts.table.loan_total.result-new-loan', compact('reports'));
    }
}
