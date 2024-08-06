<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResultOperationController extends Controller
{
    

    // function index

    public function index () {
        return view('layouts.table.result-total-operation-table');
    }
}
