<?php

namespace App\Http\Controllers;

use App\Export\MissionExport\MissionsExport;
use App\Models\Result\ResultMission;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ResultMissionController extends Controller
{

    // If you need a method to show missions, define it here
    public function show($id)
    {
        $mission = ResultMission::findOrFail($id);
        return view('missions.show', compact('mission'));
    }

    // Define the locations array as a class property
    protected $locations = [
        'none' => 0,
        'កំពង់ធំ' => 268800,
        'តាកែវ' => 123200,
        'សៀមរាប' => 499200,
        'កំពង់ចាម' => 201600,
        'បាត់ដំបង' => 465600,
        'ប៉ៃលិន' => 630400,
        'បន្ទាយមានជ័យ' => 576000,
        'ពោធិ៍សាត់' => 296000,
        'ព្រះសីហនុ' => 361600,
        'កំពត' => 235200,
        'កែប' => 256000,
        'ឧត្តរមានជ័យ' => 705600,
        'ព្រៃវែង' => 144000,
        'ស្វាយរៀង' => 200000,
        'ត្បូងឃ្មុំ' => 273600,
        'ក្រចេះ' => 537600,
        'មណ្ឌលគីរី' => 611200,
        'រតនគីរី' => 942400,
        'កណ្ដាល' => 17600,
        'កោះកុង' => 464000,
        'កំពង់ស្ពី' => 72000,
        'ស្ទឹងត្រែង' => 748800,
        'ព្រះវិហារ' => 480000,
        'កំពង់ឆ្នាំង' => 145600
    ];

    public function index()
    {
        // Retrieve all missions from the database
        $resultMission  = ResultMission::all();

        // Pass the missions and locations data to the view
        return view('layouts.admin.forms.form-mission.form-mission-index', [
            'missions' => $resultMission,
            'locations' => $this->locations,
        ]);
    }

    public function create()
    {
        return view('layouts.admin.forms.form-mission.form-mission-create');
    }

    public function store(Request $request)
    {
        // Define possible roles
        $roles = ['អគ្កាធិការរង', 'អគ្គនាយករង', 'អគ្គលេខាធិការរង', 'រដ្ឋលេខាធិការ', 'រដ្ឋលេខាធិការ', 'អនុរដ្ឋលេខាធិការ', 'ប្រ.ការិយាល័យ', 'អនុ.ការិយាល័យ', 'អនុប្រធានផ្នែក', 'មន្ត្រី', 'ជំនួយការ'];

        // Define possible position types
        $positionTypes = [
            'ក' => ['pocket_money' => 40000, 'meal_money' => 120000, 'accommodation_money' => 240000],
            'ខ១' => ['pocket_money' => 35000, 'meal_money' => 90000, 'accommodation_money' => 160000],
            'ខ២' => ['pocket_money' => 30000, 'meal_money' => 80000, 'accommodation_money' => 120000],
            'គ' => ['pocket_money' => 24000, 'meal_money' => 70000, 'accommodation_money' => 100000],
            'ឃ' => ['pocket_money' => 20000, 'meal_money' => 60000, 'accommodation_money' => 80000],
            'ង' => ['pocket_money' => 16000, 'meal_money' => 60000, 'accommodation_money' => 80000],
        ];

        // Validate and process the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'role' => ['required', 'string', 'in:' . implode(',', $roles)],
            'position_type' => ['required', 'string', 'in:' . implode(',', array_keys($positionTypes))],
            'letter_number' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'mission_objective' => 'required|string',
            'location' => ['required', 'string', 'in:' . implode(',', array_keys($this->locations))],
            'mission_start_date' => 'required|date',
            'mission_end_date' => 'required|date|after_or_equal:mission_start_date',
        ]);

        // Calculate the duration of the mission
        $missionStartDate = new \DateTime($request->mission_start_date);
        $missionEndDate = new \DateTime($request->mission_end_date);
        $daysCount = $missionStartDate->diff($missionEndDate)->days + 1;
        $nightsCount = $daysCount - 1;

        // Get the position type values
        $positionType = $validatedData['position_type'];
        $pocketMoneyPerDay = $positionTypes[$positionType]['pocket_money'];
        $mealMoneyPerDay = $positionTypes[$positionType]['meal_money'];
        $accommodationMoneyPerNight = $positionTypes[$positionType]['accommodation_money'];
        $location = $validatedData['location'];
        // $travelAllowancePerDay = $this->locations[$location];

        // Calculate total values
        $totalPocketMoney = $pocketMoneyPerDay * $daysCount;
        $totalMealMoney = $mealMoneyPerDay * $daysCount;
        $totalAccommodationMoney = $accommodationMoneyPerNight * $nightsCount;
        $finalTotal = $totalPocketMoney + $totalMealMoney + $totalAccommodationMoney;

        // Add the calculated money values to the validated data
        $validatedData['days_count'] = $daysCount;
        $validatedData['nights_count'] = $nightsCount;
        $validatedData['pocket_money'] = $pocketMoneyPerDay;
        $validatedData['meal_money'] = $mealMoneyPerDay;
        $validatedData['accommodation_money'] = $accommodationMoneyPerNight;
        // $validatedData['travel_allowance'] = $travelAllowancePerDay;

        // Add the total money values to the validated data
        $validatedData['total_pocket_money'] = $totalPocketMoney;
        $validatedData['total_meal_money'] = $totalMealMoney;
        $validatedData['total_accommodation_money'] = $totalAccommodationMoney;
        $validatedData['final_total'] = $finalTotal;

        // Create a new Mission
        ResultMission::create($validatedData);

        // Redirect or return a response
        return redirect()->route('missions.index')->with('success', 'Mission created successfully.');
    }
}
