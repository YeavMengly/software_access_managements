<?php 

namespace App\Http\Controllers;

use App\Exports\CambodiaExport;
use App\Models\Result\CambodiaMission;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class MissionCambodiaController extends Controller
{
    // Define the locations array as a class property
    protected $locations = [
        'កំពង់ធំ',
        'តាកែវ',
        'សៀមរាប',
        'កំពង់ចាម',
        'បាត់ដំបង',
        'ប៉ៃលិន',
        'បន្ទាយមានជ័យ',
        'ពោធិ៍សាត់',
        'ព្រះសីហនុ',
        'កំពត',
        'កែប',
        'ឧត្តរមានជ័យ',
        'ព្រៃវែង',
        'ស្វាយរៀង',
        'ត្បូងឃ្មុំ',
        'ក្រចេះ',
        'មណ្ឌលគីរី',
        'រតនគីរី',
        'កណ្ដាល',
        'កោះកុង',
        'កំពង់ស្ពី',
        'ស្ទឹងត្រែង',
        'ព្រះវិហារ',
        'កំពង់ឆ្នាំង'
    ];

  
    public function index(Request $request)
    {
        $missions = CambodiaMission::all();

        $search = $request->input('search');

        // Filter missions based on predefined locations and search term
        $missions = CambodiaMission::query()
            ->whereIn('location', $this->locations)
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                            ->orWhere('location', 'like', "%{$search}%");
            })
            ->get();

        // Calculate totals
        $totals = [
            'travel_allowance' => $missions->sum('travel_allowance'),
            'total_pocket_money' => $missions->sum('total_pocket_money'),
            'total_meal_money' => $missions->sum('total_meal_money'),
            'total_accommodation_money' => $missions->sum('total_accommodation_money'),
            'final_total' => $missions->sum('final_total'),
        ];

        // Pass the missions data and totals to the view
        return view('layouts.table.table-mission.table-mission-cambodia', compact('missions', 'totals'));
    }

    // Export data to excel file
    public function export(Request $request)
    {
        $search = $request->input('search');
        return Excel::download(new CambodiaExport($search), 'mission-cambodia.xlsx');
    }
}