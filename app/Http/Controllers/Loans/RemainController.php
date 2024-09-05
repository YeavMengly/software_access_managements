<?php

namespace App\Http\Controllers\Loans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RemainController extends Controller
{
    //
    public function index(){
        return view('layouts.table.loan_total.result-remain');
    }
}
