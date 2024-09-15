<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExcelExportController extends Controller
{
    public function index()
    {
        return view('export-excel');
    }
}
