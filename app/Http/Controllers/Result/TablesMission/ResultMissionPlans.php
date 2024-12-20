<?php

namespace App\Http\Controllers\Result\TablesMission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResultMissionPlans extends Controller
{
    //

    public function index(){
        return view('layouts.table.table-mission.mission-plans.table-ms-plan');
    }
}
