<?php

namespace App\Http\Controllers\Loans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewLoanController extends Controller
{
    //
    public function index(){
        return view('layouts.table.loan_total.result-new-loan');
    }
}
