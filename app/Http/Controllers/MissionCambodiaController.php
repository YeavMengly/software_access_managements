<?php

namespace App\Http\Controllers;

use App\Exports\CambodiaExport;
use App\Models\Result\CambodiaMission;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;

class MissionCambodiaController extends Controller
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

    public function index(Request $request)
    {
        // Retrieve search queries
        $search = $request->input('search');
        $searchDate = $request->input('search_date');

        // Initialize query builder
        $query = CambodiaMission::query();

        // Filter by text search if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        // Filter by mission_start_date if provided
        if ($searchDate) {
            $query->whereDate('mission_start_date', $searchDate);
        }

        // Fetch missions
        $missions = $query->get();

        // Calculate totals
        $totals = [
            'travel_allowance' => $missions->sum('travel_allowance'),
            'total_pocket_money' => $missions->sum('total_pocket_money'),
            'total_meal_money' => $missions->sum('total_meal_money'),
            'total_accommodation_money' => $missions->sum('total_accommodation_money'),
            'final_total' => $missions->sum('final_total'),
        ];

        // Pass the missions and totals to the view
        return view('layouts.table.table-mission.table-mission-cambodia', [
            'missions' => $missions,
            'totals' => $totals,
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
            'ជំនួយការ',
        ];

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
            'location' => 'required',
            'mission_start_date' => 'required|date',
            'mission_end_date' => 'required|date|after_or_equal:mission_start_date',
        ]);

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
            'location' => $request->location,
            'mission_start_date' => $request->mission_start_date,
            'mission_end_date' => $request->mission_end_date,
            'days_count' => $daysCount,
            'nights_count' => $nightsCount,
        ];

        // Variable to hold the final mission ID
        // Ensure arrays are initialized
        $names = $request->names ?? [];
        $people = $request->people ?? [];

        // Validate if arrays are not empty and have the same length
        if (!is_array($names) || !is_array($people) || count($names) !== count($people)) {
            return response()->json(['error' => 'Invalid input data'], 400);
        }

        foreach ($names as $index => $name) {
            $role = $people[$index]['role'] ?? '';
            $positionType = $people[$index]['position_type'] ?? '';

            // Check if positionType is valid
            if (!isset($positionTypes[$positionType])) {
                return response()->json(['error' => 'Invalid position type'], 400);
            }

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
            $missions = CambodiaMission::create(array_merge($missionData, $personData))->id;
        }

        // Redirect or return a response
        return redirect()->route('mission-cam.index')->with('success', 'Mission created successfully.');
    }

    // Example method to calculate travel allowance (you can adjust this as needed)
    protected function calculateTravelAllowance($location)
    {

        // Define travel allowances based on location (example logic)
        $travelAllowanceRates = [
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
        // Use the protected $locations array to get the travel allowance for the location
        return $this->locations[$location] ?? 0;
    }

    public function edit($id)
    {
        // Fetch the mission data
        $missions = CambodiaMission::findOrFail($id);

        // Get existing people associated with the mission
        $person = CambodiaMission::where('id', $id)->first();

        // Pass data to the view
        return view('layouts.admin.forms.form-mission.mission-edit', [
            'missions' => $missions,
            'people' => $person,
            'locations' => $this->locations,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Define possible position types and their corresponding allowances for one person
        $positionTypes = [
            'ក' => ['pocket_money' => 40000, 'meal_money' => 120000, 'accommodation_money' => 240000],
            'ខ១' => ['pocket_money' => 35000, 'meal_money' => 90000, 'accommodation_money' => 160000],
            'ខ២' => ['pocket_money' => 30000, 'meal_money' => 80000, 'accommodation_money' => 120000],
            'គ' => ['pocket_money' => 24000, 'meal_money' => 70000, 'accommodation_money' => 100000],
            'ឃ' => ['pocket_money' => 20000, 'meal_money' => 60000, 'accommodation_money' => 80000],
            'ង' => ['pocket_money' => 16000, 'meal_money' => 60000, 'accommodation_money' => 80000],
        ];

        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'position_type' => 'required|string|max:255',
            'letter_number' => 'required|numeric',
            'letter_date' => 'required|date',
            'mission_objective' => 'required|string|max:255',
            'location' => 'nullable|string',
            'mission_start_date' => 'required|date',
            'mission_end_date' => 'required|date|after_or_equal:mission_start_date',
            'travel_allowance' => 'required|numeric|min:0',
        ]);

        // Get the position type values
        $positionType = $validatedData['position_type'];



        // Get the allowance amounts for the given position type (for one person)
        $pocketMoneyPerDay = $positionTypes[$positionType]['pocket_money'] ?? 0;
        $mealMoneyPerDay = $positionTypes[$positionType]['meal_money'] ?? 0;
        $accommodationMoneyPerNight = $positionTypes[$positionType]['accommodation_money'] ?? 0;

        // Find the mission record
        $mission = CambodiaMission::findOrFail($id);

        // Calculate the duration of the mission
        $missionStartDate = new \DateTime($request->mission_start_date);
        $missionEndDate = new \DateTime($request->mission_end_date);
        $daysCount = $missionStartDate->diff($missionEndDate)->days + 1;
        $nightsCount = $daysCount - 1;

        // Automatically calculate total allowances for one person based on position type and mission duration
        $pocketMoneyTotal = $pocketMoneyPerDay * $daysCount;
        $mealMoneyTotal = $mealMoneyPerDay * $daysCount;
        $accommodationMoneyTotal = $accommodationMoneyPerNight * $nightsCount;

        // Check if location has changed
        if ($request->location !== $mission->location) {
            // Calculate travel allowance based on the new location
            $newTravelAllowance = $this->calculateTravelAllowance($request->location);

            // If the new travel allowance is greater than 0, update it; otherwise, keep the existing one
            if ($newTravelAllowance > 0) {
                $travelAllowance = $newTravelAllowance;
            } else {
                $travelAllowance = $validatedData['travel_allowance'];
            }
        } else {
            // If location hasn't changed, use the input value from the form
            $travelAllowance = $validatedData['travel_allowance'];
        }

        $finalTotal = $pocketMoneyTotal + $mealMoneyTotal + $accommodationMoneyTotal + $travelAllowance;

        // Prepare data for updating
        $updateData = [
            'name' => $validatedData['name'],
            'role' => $validatedData['role'],
            'position_type' => $validatedData['position_type'],
            'letter_number' => $validatedData['letter_number'],
            'letter_date' => $validatedData['letter_date'],
            'mission_objective' => $validatedData['mission_objective'],
            'location' => $request->location,
            'mission_start_date' => $validatedData['mission_start_date'],
            'mission_end_date' => $validatedData['mission_end_date'],
            'days_count' => $daysCount,
            'nights_count' => $nightsCount,
            'travel_allowance' => $travelAllowance,
            'pocket_money' => $pocketMoneyPerDay,
            'meal_money' => $mealMoneyPerDay,
            'accommodation_money' => $accommodationMoneyPerNight,
            'total_pocket_money' => $pocketMoneyTotal,
            'total_meal_money' => $mealMoneyTotal,
            'total_accommodation_money' => $accommodationMoneyTotal,
            'final_total' => $finalTotal,
        ];

        // Update the mission record
        $mission->update($updateData);

        // Redirect with success message
        return redirect()->route('mission-cam.index')->with('success', 'Mission updated successfully');
    }

    public function destroy($id)
    {
        // Find the mission and delete it
        $mission = CambodiaMission::findOrFail($id);
        $mission->delete();

        // Redirect back with a success message
        return redirect()->route('mission-cam.index')->with('success', 'Mission deleted successfully.');
    }

    // Export data to Excel file
    public function export(Request $request)
    {
        $search = $request->input('search');
        $searchDate = $request->input('search_date');

        return Excel::download(new CambodiaExport($search, $searchDate), 'mission-cambodia.xlsx');
    }
}
