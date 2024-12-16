<?php

namespace App\Http\Controllers\Result\ResultSuccess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPlanCenterController extends Controller
{
    public function index (){
        return view('layouts.table.result-success-table.result-administrative-plan');
    }
}
