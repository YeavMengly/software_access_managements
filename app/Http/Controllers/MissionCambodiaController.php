<?php

namespace App\Http\Controllers;

use App\Exports\MissionExport;
use App\Models\Result\ResultMission;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;


class MissionCambodiaController extends Controller
{

    public function index(Request $request)
    {
        // Retrieve all missions from the database
        $missions = ResultMission::all();
        $search = $request->input('search');

        $missions = ResultMission::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            })
            ->get();

        // Pass the missions data to the view
        return view('layouts.table.table-mission.table-mission-cambodia', compact('missions'));
    }

    //export data to excel file
    public function export(Request $request)
    {
        $search = $request->input('search');

        return Excel::download(new MissionExport($search), 'mission-cambodia.xlsx');
    }
}
