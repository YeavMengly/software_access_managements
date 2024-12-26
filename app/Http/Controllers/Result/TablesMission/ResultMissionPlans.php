<?php

namespace App\Http\Controllers\Result\TablesMission;

use App\Http\Controllers\Controller;
use App\Models\Mission\MissionPlanning;
use Illuminate\Http\Request;

class ResultMissionPlans extends Controller
{
    //
    public function index()
    {
        // Retrieve and sort mission planning data by sub_account_key
        $missionPlannings = MissionPlanning::with(['missionType', 'subAccountKey'])
            ->orderBy('sub_account_key') // Sort by sub_account_key
            ->get();
    
        // Pass the sorted data to the view
        return view('layouts.table.table-mission.mission-plans.table-ms-plan', compact('missionPlannings'));
    }
    
}
