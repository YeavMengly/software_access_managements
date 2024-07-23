<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function index (){
        return view('layouts.admin.forms.code.report-index');
    }

    public function create () {

        return view('layouts.admin.forms.code.report-create');
    }
}
