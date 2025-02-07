<?php

namespace App\Http\Controllers;

use App\Exports\CambodiaExport;
use App\Models\Mission\MissionTag;
use App\Models\Result\CambodiaMission;
use Carbon\Carbon;
use Hamcrest\Core\AllOf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        'កំពង់ស្ពឺ' => 72000,
        'ស្ទឹងត្រែង' => 748800,
        'ព្រះវិហារ' => 480000,
        'កំពង់ឆ្នាំង' => 145600
    ];

    public function index(Request $request)
    {
        // Retrieve search queries
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedYear = $request->input('year', date('Y'));
        $selectedMonth = $request->input('month', now()->month);
        $selectedMissionTag = $request->input('m_tag');
        $selectedProgramFormat = $request->input('p_format'); // 📌 Capture program format
        $missionTag = MissionTag::all();

        // Initialize query builder
        $query = CambodiaMission::query();

        // Filter by text search if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%');
            });

            // Clone the query to fetch letter_numbers from filtered results
            $matchingMissions = clone $query;
            $letterNumbers = $matchingMissions->pluck('letter_number')->unique();

            // If letter_numbers exist, refine the query
            if ($letterNumbers->count() > 0) {
                $query->whereIn('letter_number', $letterNumbers);
            $matchingMissions = $query->get();
            $letterNumbers = $matchingMissions->pluck('letter_number')->unique();

            if ($letterNumbers->count() > 0) {
                $query = CambodiaMission::whereIn('letter_number', $letterNumbers);
            }
        }

        // Filter by date range
        if ($startDate && $endDate) {
            try {
                $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
                $endDate = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } catch (\Exception $e) {
                Log::error('Invalid date format: ' . $e->getMessage());
                return redirect()->back()->withErrors(['date' => 'Invalid date format. Please use YYYY-MM-DD format.']);
            }
        } elseif ($startDate) {
            try {
                $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
                $query->where('created_at', '>=', $startDate);
            } catch (\Exception $e) {
                Log::error('Invalid date format: ' . $e->getMessage());
                return redirect()->back()->withErrors(['date' => 'Invalid date format. Please use YYYY-MM-DD format.']);
            }
        }

        // Filter by selected year and month
        if ($selectedYear) {
            $query->whereYear('created_at', $selectedYear);
        }
        if ($selectedMonth) {
            $query->whereMonth('created_at', $selectedMonth);
        }

        // Filter by mission tag if provided

        // Filter by Mission Tag
          if ($selectedMissionTag) {
            $query->where('m_tag', $selectedMissionTag);
        }


        // 📌 Filter by Program Format
        if ($selectedProgramFormat) {
            $query->where('p_format', $selectedProgramFormat);
        }

        // Fetch missions
        $missions = $query->paginate(20); // ✅ Use pagination

        // Calculate totals
        $totals = [
            'travel_allowance' => $missions->sum('travel_allowance'),
            'total_pocket_money' => $missions->sum('total_pocket_money'),
            'total_meal_money' => $missions->sum('total_meal_money'),
            'total_accommodation_money' => $missions->sum('total_accommodation_money'),
            'final_total' => $missions->sum('final_total'),
        ];

        // Grouped totals by letter_number
        $groupedTotals = $missions->groupBy('letter_number')->map(function ($group) {
            return [
                'travel_allowance' => $group->sum('travel_allowance'),
                'total_pocket_money' => $group->sum('total_pocket_money'),
                'total_meal_money' => $group->sum('total_meal_money'),
                'total_accommodation_money' => $group->sum('total_accommodation_money'),
                'final_total' => $group->sum('final_total'),
            ];
        });


        return view('layouts.table.table-mission.table-mission-cambodia', [
            'missionTag' => $missionTag,
            'missions' => $missions,
            'totals' => $totals,
            'groupedTotals' => $groupedTotals,
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
            'selectedProgramFormat' => $selectedProgramFormat, // ✅ Send to the view
        ]);
    }


    public function create()
    {
        $missionTag = MissionTag::all();
        return view('layouts.admin.forms.form-mission.form-mission-create', compact('missionTag'));
    }

    public function store(Request $request)
    {
        // Define possible roles
        $roles = [
            'រដ្ឋមន្រ្តី',
            'ទីប្រឹក្សាអមក្រសួង',
            'រដ្ឋលេខាធិការ',
            'អនុរដ្ឋលេខាធិការ',
            'អគ្កាធិការ',
            'អគ្កាធិការរង',
            'អគ្គនាយក',
            'អគ្គនាយករង',
            'អគ្គលេខាធិការ',
            'អគ្គលេខាធិការរង',
            'ប្រ.នាយកដ្ឋាន',
            'អនុ.នាយកដ្ឋាន',
            'ប្រ.ការិយាល័យ',
            'អនុ.ការិយាល័យ',
            'នាយកវិទ្យាស្ថាន',
            'ប្រធានផ្នែក',
            'អនុប្រធានផ្នែក',
            'មន្ត្រី',
            'ជំនួយការ',
            'មន្ត្រីជាប់កិច្ចសន្យា',
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

        $validatedData = $request->validate([
            'names.*' => 'required|string|max:255',
            'people.*.role' => ['required', 'string', Rule::in($roles)],
            'people.*.position_type' => 'required|string|in:ក,ខ១,ខ២,គ,ឃ,ង',
            'letter_number' => 'required|string',
            'letter_format' => 'required|string',
            'full_letter_number' => 'required|string',
            'letter_date' => 'required|date',
            'mission_objective' => 'required|string',
            'location' => 'required',
            'mission_start_date' => 'required|date',
            'mission_end_date' => 'required|date|after_or_equal:mission_start_date',
            'm_tag' => 'required|exists:mission_tags,id', // Validation rule for m_tag
            'p_format' => 'required|string',
        ]);

        // Retrieve the combined letter number and format
        $fullLetterNumber = $request->input('full_letter_number');

        // Calculate the duration of the mission
        $missionStartDate = new \DateTime($request->mission_start_date);
        $missionEndDate = new \DateTime($request->mission_end_date);
        $daysCount = $missionStartDate->diff($missionEndDate)->days + 1;
        $nightsCount = $daysCount - 1;

        // Parse dates
        $letterDate = Carbon::parse($request->letter_date);
        $missionStartDate = Carbon::parse($request->mission_start_date);

        // Check the condition
        if ($missionStartDate->lessThan($letterDate)) {
            // Return an error message
            return redirect()->back()->with('error', 'កាលបរិច្ឆេទចាប់ផ្តើមបេសកកម្មមិនអាចមុនកាលបរិច្ឆេទនៃលិខិតនោះទេ។');
        }

        // Prepare data for the mission (this will be used for all persons)
        $missionData = [
            'letter_number' => $request->letter_number,
            'letter_format' => $request->letter_format,
            'full_letter_number' => $fullLetterNumber,
            'letter_date' => $request->letter_date,
            'mission_objective' => $request->mission_objective,
            'location' => $request->location,
            'mission_start_date' => $request->mission_start_date,
            'mission_end_date' => $request->mission_end_date,
            'days_count' => $daysCount,
            'nights_count' => $nightsCount,
            'm_tag' => $validatedData['m_tag'],
            'p_format' => $request->p_format
        ];

        // Variable to hold the final mission ID
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

            // Check for duplicate mission
            $existingMission = CambodiaMission::where('name', $name)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('mission_start_date', [$request->mission_start_date, $request->mission_end_date])
                        ->orWhereBetween('mission_end_date', [$request->mission_start_date, $request->mission_end_date]);
                })
                ->where('letter_number', '!=', $request->letter_number) // Exclude same letter_number
                ->first();

            if ($existingMission) {
                // If a mission exists with the same name, overlapping dates, and a different letter number
                return back()->withErrors(['error' => "ឈ្មោះ '$name' បានចុះបេសកកម្មនៅថ្ងៃនេះរួចហើយ។"]);
            }

            // Calculate the new mission duration
            $missionStartDate = new \DateTime($request->mission_start_date);
            $missionEndDate = new \DateTime($request->mission_end_date);
            $newMissionDays = $missionStartDate->diff($missionEndDate)->days + 1;

            // Retrieve existing missions for this person within the same month
            $existingMissionsThisMonth = CambodiaMission::where('name', $name)
                ->whereMonth('mission_start_date', $missionStartDate->format('m'))
                ->whereYear('mission_start_date', $missionStartDate->format('Y'))
                ->get();

            // Calculate total days in existing missions
            $totalExistingDays = 0;
            foreach ($existingMissionsThisMonth as $existingMission) {
                $existingStartDate = new \DateTime($existingMission->mission_start_date);
                $existingEndDate = new \DateTime($existingMission->mission_end_date);
                $totalExistingDays += $existingStartDate->diff($existingEndDate)->days + 1;
            }

            // Check if total days exceed 10
            $totalDays = $totalExistingDays + $newMissionDays;
            if ($totalDays > 10) {
                return back()->withErrors(['error' => "ឈ្មោះ '$name' មិនអាចចុះបេសកកម្មលើសពី ១០ ថ្ងៃក្នុងមួយខែ។"]);
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
            'កំពង់ស្ពឺ' => 72000,
            'ស្ទឹងត្រែង' => 748800,
            'ព្រះវិហារ' => 480000,
            'កំពង់ឆ្នាំង' => 145600
        ];
        // Use the protected $locations array to get the travel allowance for the location
        return $this->locations[$location] ?? 0;
    }

    public function edit($id)
    {
        // Fetch the mission to edit by ID
        $mission = CambodiaMission::findOrFail($id);

        // Fetch all Mission Tags
        $missionTag = MissionTag::all();
        // Return the view with existing data

        $roles = [
            'រដ្ឋមន្រ្តី',
            'ទីប្រឹក្សាអមក្រសួង',
            'រដ្ឋលេខាធិការ',
            'អនុរដ្ឋលេខាធិការ',
            'អគ្កាធិការ',
            'អគ្កាធិការរង',
            'អគ្គនាយក',
            'អគ្គនាយករង',
            'អគ្គលេខាធិការ',
            'អគ្គលេខាធិការរង',
            'ប្រ.នាយកដ្ឋាន',
            'អនុ.នាយកដ្ឋាន',
            'ប្រ.ការិយាល័យ',
            'អនុ.ការិយាល័យ',
            'នាយកវិទ្យាស្ថាន',
            'ប្រធានផ្នែក',
            'អនុប្រធានផ្នែក',
            'មន្ត្រី',
            'ជំនួយការ',
            'មន្ត្រីជាប់កិច្ចសន្យា',
        ];


        return view('layouts.admin.forms.form-mission.mission-edit', compact('mission', 'missionTag', 'roles'));
    }

    public function update(Request $request, $id)
    {
        // Define possible roles
        $roles = [
            'រដ្ឋមន្រ្តី',
            'ទីប្រឹក្សាអមក្រសួង',
            'រដ្ឋលេខាធិការ',
            'អនុរដ្ឋលេខាធិការ',
            'អគ្កាធិការ',
            'អគ្កាធិការរង',
            'អគ្គនាយក',
            'អគ្គនាយករង',
            'អគ្គលេខាធិការ',
            'អគ្គលេខាធិការរង',
            'ប្រ.នាយកដ្ឋាន',
            'អនុ.នាយកដ្ឋាន',
            'ប្រ.ការិយាល័យ',
            'អនុ.ការិយាល័យ',
            'នាយកវិទ្យាស្ថាន',
            'ប្រធានផ្នែក',
            'អនុប្រធានផ្នែក',
            'មន្ត្រី',
            'ជំនួយការ',
            'មន្ត្រីជាប់កិច្ចសន្យា',
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

        $validatedData = $request->validate([
            'names.*' => 'required|string|max:255',
            'role.*' => ['required', 'string', Rule::in($roles)],
            'position_type.*' => 'required|string|in:ក,ខ១,ខ២,គ,ឃ,ង',
            'letter_number' => 'required|string',
            'letter_format' => 'required|string',
            'full_letter_number' => 'required|string',
            'letter_date' => 'required|date',
            'mission_objective' => 'required|string',
            'location' => 'required',
            'mission_start_date' => 'required|date',
            'mission_end_date' => 'required|date|after_or_equal:mission_start_date',
            'm_tag' => 'required|exists:mission_tags,id', // Validation rule for m_tag
            'p_format' => 'required|string',
        ]);

        // Calculate the duration of the mission
        $missionStartDate = new \DateTime($request->mission_start_date);
        $missionEndDate = new \DateTime($request->mission_end_date);
        $daysCount = $missionStartDate->diff($missionEndDate)->days + 1;
        $nightsCount = $daysCount - 1;

        // Parse dates
        $letterDate = Carbon::parse($request->letter_date);
        $missionStartDate = Carbon::parse($request->mission_start_date);

        // Check the condition
        if ($missionStartDate->lessThan($letterDate)) {
            // Return an error message
            return redirect()->back()->with('error', 'កាលបរិច្ឆេទចាប់ផ្តើមបេសកកម្មមិនអាចមុនកាលបរិច្ឆេទនៃលិខិតនោះទេ។');
        }

        // Prepare data for the mission (this will be used for all persons)
        $missionData = [
            'letter_number' => $request->letter_number,
            'letter_format' => $request->letter_format,
            // 'full_letter_number' => $fullLetterNumber,
            'letter_date' => $request->letter_date,
            'mission_objective' => $request->mission_objective,
            'location' => $request->location,
            'mission_start_date' => $request->mission_start_date,
            'mission_end_date' => $request->mission_end_date,
            'days_count' => $daysCount,
            'nights_count' => $nightsCount,
            'm_tag' => $validatedData['m_tag'],
            'p_format' => $request->p_format
        ];


        // Variable to hold the final mission ID
        $names = $request->names ?? [];
        $people = $request->people ?? [];

        if (count($names) !== count($roles) || count($names) !== count($positionTypes)) {
            return response()->json(['error' => 'Invalid input data'], 400);
        }

        foreach ($names as $index => $name) {
            // $role = $people[$index]['role'] ?? '';
            // $positionType = $people[$index]['position_type'] ?? '';
            $role = $roles[$index];
            $positionType = $positionTypes[$index];


            // Check if positionType is valid
            if (!isset($positionTypes[$positionType])) {
                return response()->json(['error' => 'Invalid position type'], 400);
            }

            // Check for duplicate mission
            $existingMission = CambodiaMission::where('name', $name)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('mission_start_date', [$request->mission_start_date, $request->mission_end_date])
                        ->orWhereBetween('mission_end_date', [$request->mission_start_date, $request->mission_end_date]);
                })
                ->where('letter_number', '!=', $request->letter_number) // Exclude same letter_number
                ->first();

            if ($existingMission) {
                // If a mission exists with the same name, overlapping dates, and a different letter number
                return back()->withErrors(['error' => "ឈ្មោះ '$name' បានចុះបេសកម្មនៅថ្ងៃនេះរួចហើយ។"]);
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

            // Update the mission data for each person
            $mission = CambodiaMission::findOrFail($id);
            $mission->update(array_merge($missionData, $personData));
            //     $mission->letter_number = $letterNumber;
            CambodiaMission::updateOrCreate(
                ['id' => $id, 'name' => $name],
                array_merge($missionData, [
                    'name' => $name,
                    'role' => $role,
                    'position_type' => $positionType,
                ])
            );
        }

        // Redirect or return a response
        return redirect()->route('mission-cam.index')->with('success', 'Mission updated successfully.');
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
        $export = new CambodiaExport($request->input('search'), $request->input('mission_start_date'));
        return $export->export($request);
    }
}
