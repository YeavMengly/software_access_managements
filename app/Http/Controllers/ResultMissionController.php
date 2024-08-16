<?php

namespace App\Http\Controllers;

use App\Models\Result\AbroadMission;
use App\Models\Result\CambodiaMission;
use App\Models\Result\ResultMission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class ResultMissionController extends Controller
{
    // Define the locations array as a class property
    protected $locations = [
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

    protected $country = [
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
        // Retrieve search query
        $search = $request->input('search');

        // Fetch missions based on search query
        $missions = $search ? ResultMission::where('name', 'like', '%' . $search . '%')
            ->orWhere('role', 'like', '%' . $search . '%')
            ->orWhere('position_type', 'like', '%' . $search . '%')
            ->orWhere('mission_objective', 'like', '%' . $search . '%')
            ->orWhere('location', 'like', '%' . $search . '%')
            ->get() : ResultMission::all();

        // Total 
        $totals = [
            'travel_allowance' => $missions->sum('travel_allowance'),
            'total_pocket_money' => $missions->sum('total_pocket_money'),
            'total_meal_money' => $missions->sum('total_meal_money'),
            'total_accommodation_money' => $missions->sum('total_accommodation_money'),
            'final_total' => $missions->sum('final_total'),
        ];

        // Pass the missions to the view
        return view('layouts.admin.forms.form-mission.form-mission-index', [
            'missions' => $missions,
            'totals' => $totals
        ]);
    }

    public function create()
    {
        return view('layouts.admin.forms.form-mission.form-mission-create');
    }

    public function store(Request $request)
    {
        // Define possible roles
        $roles = [
            'អគ្កាធិការរង',
            'អគ្គនាយករង',
            'អគ្គលេខាធិការរង',
            'រដ្ឋលេខាធិការ',
            'អនុរដ្ឋលេខាធិការ',
            'ប្រ.ការិយាល័យ',
            'អនុ.ការិយាល័យ',
            'អនុប្រធានផ្នែក',
            'មន្ត្រី',
            'ជំនួយការ'
        ];

        // Log the roles submitted for each person
        Log::info('Submitted Roles:', $request->input('people.*.role'));

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
            'names.*' => 'required|string|max:255',
            'people.*.role' => ['required', 'string', Rule::in($roles)],
            'people.*.position_type' => 'required|string|in:ក,ខ១,ខ២,គ,ឃ,ង',
            'letter_number' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'mission_objective' => 'required|string',
            'place' => 'required|string|in:within_country,abroad',
            'location' => ['nullable', 'string'],
            'country' => ['nullable', 'string'],
            'mission_start_date' => 'required|date',
            'mission_end_date' => 'required|date|after_or_equal:mission_start_date',
        ]);

        // Ensure that either location or country is provided
        if ($validatedData['place'] === 'within_country' && empty($validatedData['location'])) {
            return back()->withErrors(['location' => 'A valid location must be selected.'])->withInput();
        }

        if ($validatedData['place'] === 'abroad' && empty($validatedData['country'])) {
            return back()->withErrors(['country' => 'A valid country must be selected.'])->withInput();
        }

        // Calculate the duration of the mission
        $missionStartDate = new \DateTime($request->mission_start_date);
        $missionEndDate = new \DateTime($request->mission_end_date);
        $daysCount = $missionStartDate->diff($missionEndDate)->days + 1;
        $nightsCount = $daysCount - 1;

        // Prepare data for the mission (this will be used for all persons)
        $missionData = [
            'letter_number' => $request->letter_number,
            'letter_date' => $request->letter_date,
            'mission_objective' => $request->mission_objective,
            'place' => $request->place,
            'location' => $request->location,
            'country' => $request->country,
            'mission_start_date' => $request->mission_start_date,
            'mission_end_date' => $request->mission_end_date,
            'days_count' => $daysCount,
            'nights_count' => $nightsCount,
        ];

        // Calculate travel allowance for the first person only
        // $travelAllowance = $this->calculateTravelAllowance($request->location);

        // Variable to hold the final mission ID
        $missions = null;

        foreach ($request->names as $index => $name) {
            $role = $request->people[$index]['role'];
            $positionType = $request->people[$index]['position_type'];
        
            // Get the position type values
            $pocketMoneyPerDay = $positionTypes[$positionType]['pocket_money'];
            $mealMoneyPerDay = $positionTypes[$positionType]['meal_money'];
            $accommodationMoneyPerNight = $positionTypes[$positionType]['accommodation_money'];
        
            // Calculate total values
            $totalPocketMoney = $pocketMoneyPerDay * $daysCount;
            $totalMealMoney = $mealMoneyPerDay * $daysCount;
            $totalAccommodationMoney = $accommodationMoneyPerNight * $nightsCount;
            $travelAllowance = $this->calculateTravelAllowance($request->location);

            $finalTotal = $totalPocketMoney + $totalMealMoney + $totalAccommodationMoney;
        
            // Prepare the data for each person
            $personData = [
                'name' => $name,
                'role' => $role,
                'position_type' => $positionType,
                'pocket_money' => $pocketMoneyPerDay,
                'meal_money' => $mealMoneyPerDay,
                'accommodation_money' => $accommodationMoneyPerNight,
                'total_pocket_money' => $totalPocketMoney,
                'total_meal_money' => $totalMealMoney,
                'total_accommodation_money' => $totalAccommodationMoney,
                'final_total' => $finalTotal,
            ];
        
            if ($index === 0) {
                // Add travel allowance only for the first person
                $personData['travel_allowance'] = $travelAllowance;
                // Update the final total for the first person
                $personData['final_total'] += $travelAllowance; 
            }
        
            // Store each person's mission data in ResultMission
            $missions = ResultMission::create(array_merge($missionData, $personData))->id;
        
            // Additionally store in CambodiaMission or AbroadMission
            if ($request->place === 'within_country') {
                CambodiaMission::create(array_merge($missionData, $personData));
            } else {
                AbroadMission::create(array_merge($missionData, $personData));
            }
        }
        

        // Redirect or return a response
        return redirect()->route('missions.index')->with('success', 'Mission created successfully.');
    }

    // Example method to calculate travel allowance (you can adjust this as needed)
    protected function calculateTravelAllowance($location)
    {
        // Use the protected $locations array to get the travel allowance for the location
        return $this->locations[$location] ?? 0;
    }
}
