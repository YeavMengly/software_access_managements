<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    //
    public function index (){
        return view('layouts.table.result');
    }
}
