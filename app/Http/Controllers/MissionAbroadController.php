<?php

namespace App\Http\Controllers;

use App\Exports\AbroadMissionExport;
use App\Models\Result\AbroadMission;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;


class MissionAbroadController extends Controller
{

    protected $locations = [
        'អាមេរិក',
        'កាណាដា',
        'ឡាវ',
        'វៀតណាម', 
        'ថៃ',
        'ចិន',
        'កូរ៉េ',
        'ជប៉ុន',
        'អូស្រ្តាលី',
        'ទួកគី',
        'ម៉ាឡេស៊ី',
        'សិង្ហបុរី',
        'មីយ៉ាន់ម៉ា',
        'អឺរ៉ុប',
    ];

    public function index(Request $request)
    {
        // Retrieve all missions from the database
        $missions = AbroadMission::all();
        $search = $request->input('search');

        $missions = AbroadMission::query()
        ->whereIn('location', $this->locations)
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            })
            ->get();

        // Pass the missions data to the view
        return view('layouts.table.table-mission.table-mission-abroad', compact('missions'));
    }

    //export data to excel file
    public function export(Request $request)
    {
        $search = $request->input('search');

        return Excel::download(new AbroadMissionExport($search), 'mission-abroad.xlsx');
    }
}
