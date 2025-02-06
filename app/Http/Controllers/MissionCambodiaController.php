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
            }
        }

        // Filter by date range if both start_date and end_date are provided
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
            // Filter by start_date if only start_date is provided
            try {
                $startDate = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay();
                $query->where('created_at', '>=', $startDate);
            } catch (\Exception $e) {
                Log::error('Invalid date format: ' . $e->getMessage());
                return redirect()->back()->withErrors(['date' => 'Invalid date format. Please use YYYY-MM-DD format.']);
            }
        }

        // Filter by selected year if provided
        if ($selectedYear) {
            $query->whereYear('created_at', $selectedYear);
        }

        // Filter by selected month if provided
        if ($selectedMonth) {
            $query->whereMonth('created_at', $selectedMonth);
        }

        // Filter by mission tag if provided
        if ($selectedMissionTag) {
            $query->where('m_tag', $selectedMissionTag);
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

        // Calculate grouped totals by 'letter_number'
        $groupedTotals = $missions->groupBy('letter_number')->map(function ($group) {
            return [
                'travel_allowance' => $group->sum('travel_allowance'),
                'total_pocket_money' => $group->sum('total_pocket_money'),
                'total_meal_money' => $group->sum('total_meal_money'),
                'total_accommodation_money' => $group->sum('total_accommodation_money'),
                'final_total' => $group->sum('final_total'),
            ];
        });

        // Pass data to the view
        return view('layouts.table.table-mission.table-mission-cambodia', [
            'missionTag' => $missionTag,
            'missions' => $missions,
            'totals' => $totals,
            'groupedTotals' => $groupedTotals,
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
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
            'm_tag' => $validatedData['m_tag']
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
        $missions = CambodiaMission::findOrFail($id);
        $people = $missions->people;
        $missionTag = MissionTag::all();
        return view('layouts.admin.forms.form-mission.mission-edit', [
            'missions' => $missions,
            'people' => $people,
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
            'letter_number' => 'required|string',
            'letter_format' => 'required|string',
            'letter_date' => 'required|date',
            'mission_objective' => 'required|string',
            'location' => 'nullable|string',
            'mission_start_date' => 'required|date',
            'mission_end_date' => 'required|date|after_or_equal:mission_start_date',
            'travel_allowance' => 'required|numeric|min:0',
        ]);

        // Retrieve data from the request
        $letterNumber = $request->input('letter_number');
        $letterFormat = $request->input('letter_format');

        // Combine the fields into the full_letter_number
        $fullLetterNumber = $letterNumber . ' ' . $letterFormat;

        // Construct the full letter number
        // $fullLetterNumber = trim($validatedData['letter_format'] . '/' . $validatedData['letter_number']);

        $name = $validatedData['name']; // Retrieve name from the validated data

        // **Check for duplicate mission**
        // $existingMission = CambodiaMission::where('name', $name)
        //     ->where(function ($query) use ($request) {
        //         $query->whereBetween('mission_start_date', [$request->mission_start_date, $request->mission_end_date])
        //             ->orWhereBetween('mission_end_date', [$request->mission_start_date, $request->mission_end_date]);
        //     })
        //     ->where('letter_number', '!=', $request->letter_number) // Exclude the same letter_number
        //     ->first();

        // if ($existingMission) {
        //     // If a mission exists with the same name, overlapping dates, and a different letter number
        //     return back()->withErrors(['error' => "ឈ្មោះ '$name' បានចុះបេសកកម្មនៅថ្ងៃនេះរួចហើយ។"]);
        // }

        // // Calculate the new mission duration
        // $missionStartDate = new \DateTime($request->mission_start_date);
        // $missionEndDate = new \DateTime($request->mission_end_date);

        // // Function to calculate the number of days within a specific month range
        // // Function to calculate the number of days within a specific month range
        // function getDaysInMonth($startDate, $endDate)
        // {
        //     $daysInMonth = [];

        //     // Loop through each month in the range
        //     while ($startDate <= $endDate) {
        //         // Get the current month and year
        //         $currentMonth = $startDate->format('m');
        //         $currentYear = $startDate->format('Y');

        //         // Get the first and last day of the current month
        //         $firstDayOfMonth = new \DateTime($currentYear . '-' . $currentMonth . '-01');
        //         $lastDayOfMonth = clone $firstDayOfMonth;
        //         $lastDayOfMonth->modify('last day of this month');

        //         // If the mission endDate is within this month, set the lastDayOfMonth as the mission's endDate
        //         if ($endDate < $lastDayOfMonth) {
        //             $lastDayOfMonth = $endDate;
        //         }

        //         // Calculate the number of days between the startDate and the last day of the month (or endDate if within the same month)
        //         $daysInMonth[$currentYear . '-' . $currentMonth] = (int)$startDate->diff($lastDayOfMonth)->days + 1;

        //         // Move the startDate to the first day of the next month
        //         $startDate = (clone $lastDayOfMonth)->modify('+1 day');
        //     }

        //     return $daysInMonth;
        // }


        // // Get the days in each month for the new mission
        // $newMissionDaysInMonths = getDaysInMonth(clone $missionStartDate, clone $missionEndDate);

        // // Retrieve existing missions for this person within the same months
        // $existingMissions = CambodiaMission::where('name', $name)
        //     ->where(function ($query) use ($missionStartDate, $missionEndDate) {
        //         $query->whereBetween('mission_start_date', [$missionStartDate, $missionEndDate])
        //             ->orWhereBetween('mission_end_date', [$missionStartDate, $missionEndDate])
        //             ->orWhere(function ($query) use ($missionStartDate, $missionEndDate) {
        //                 $query->where('mission_start_date', '<=', $missionStartDate)
        //                     ->where('mission_end_date', '>=', $missionEndDate);
        //             });
        //     })
        //     ->get();


        // // Calculate total days in existing missions for each month
        // $totalExistingDaysInMonths = [];
        // foreach ($existingMissions as $existingMission) {
        //     $existingStartDate = new \DateTime($existingMission->mission_start_date);
        //     $existingEndDate = new \DateTime($existingMission->mission_end_date);
        //     $existingDaysInMonths = getDaysInMonth($existingStartDate, $existingEndDate);

        //     // Add the existing mission days to the total per month
        //     foreach ($existingDaysInMonths as $monthYear => $days) {
        //         if (isset($totalExistingDaysInMonths[$monthYear])) {
        //             $totalExistingDaysInMonths[$monthYear] += $days;
        //         } else {
        //             $totalExistingDaysInMonths[$monthYear] = $days;
        //         }
        //     }
        // }

        // // Check if total days exceed 10 days per month (but only consider the days in the same month)
        // foreach ($newMissionDaysInMonths as $monthYear => $newDays) {
        //     // Total days for the month (new + existing)
        //     $totalDaysInMonth = $newDays + ($totalExistingDaysInMonths[$monthYear] ?? 0);

        //     // If total days in the month exceed 10, return an error
        //     if ($totalDaysInMonth > 10) {
        //         return back()->withErrors(['error' => "ឈ្មោះ '$name' មិនអាចចុះបេសកកម្មលើសពី ១០ ថ្ងៃក្នុងមួយខែ ($monthYear)។"]);
        //     }
        // }

        // Retrieve the existing mission record
        $mission = CambodiaMission::findOrFail($id);

        // Get the position type values
        $positionType = $validatedData['position_type'];

        // Get the allowance amounts for the given position type (for one person)
        $pocketMoneyPerDay = $positionTypes[$positionType]['pocket_money'] ?? 0;
        $mealMoneyPerDay = $positionTypes[$positionType]['meal_money'] ?? 0;
        $accommodationMoneyPerNight = $positionTypes[$positionType]['accommodation_money'] ?? 0;

        // Find the mission record
        // $mission = CambodiaMission::findOrFail($id);

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
            'letter_format' => $validatedData['letter_format'],
            'full_letter_number' => $fullLetterNumber,
            'letter_date' => $validatedData['letter_date'],
            'mission_objective' => $validatedData['mission_objective'],
            'location' => $validatedData['location'],
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
        $mission = CambodiaMission::findOrFail($id);
        $mission->update($updateData);
        $mission->letter_number = $letterNumber;
        $mission->letter_format = $letterFormat;
        $mission->full_letter_number = $fullLetterNumber;

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
        $export = new CambodiaExport($request->input('search'), $request->input('mission_start_date'));
        return $export->export($request);
    }
}
