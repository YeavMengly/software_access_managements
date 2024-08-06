<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class ResultSummariesController extends Controller
{
    //
    public function index () {
        return view('layouts.table.result-total-summaries-table');
    }
}
