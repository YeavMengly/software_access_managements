<?php

namespace App\Http\Controllers\Waters;

use App\Http\Controllers\Controller;
use App\Models\PC\ProvinceCity;
use App\Models\Waters\TitleUsageUnitWater;
use App\Models\Waters\Water;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WaterController extends Controller
{
    public function index(Request $request)
    {
        // Initialize query
        $query = Water::query();

        // Combined search by title_usage_unit or location_number
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('usage_unit_water', 'like', '%' . $searchTerm . '%')
                    ->orWhere('location_number_water', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by start_date and end_date if provided
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

            if ($startDate->greaterThan($endDate)) {
                return redirect()->back()->with('error', 'Start date must be before end date.');
            }

            // Apply the date range filter to the query
            $query->whereBetween('usage_date', [$startDate, $endDate]);
        }

        $query->orderBy('location_number_water', 'asc');

        // Paginate the results
        $waters = $query->paginate(10);

        // Fetch all necessary data to pass to the view
        $provinceCities = ProvinceCity::all(); // Fetch all ProvinceCity data
        $titleUsageUnitsWater = TitleUsageUnitWater::all();

        $totalKilowatt = $query->sum('kilowatt_water');
        $totalCost = $query->sum('total_cost');

        // Count occurrences for rowspan logic
        $rowspanCounts = [];
        foreach ($waters as $water) {
            $location = $water->location_number_water;
            $unit = $water->usage_unit_water;
            $createdYear = Carbon::parse($water->created_at)->format('Y');

            $rowspanCounts[$location][$unit][$createdYear] = ($rowspanCounts[$location][$unit][$createdYear] ?? 0) + 1;
        }

        return view('layouts.admin.forms.invoice_water.invoice-water-index', compact(
            'provinceCities', // Pass to the view
            'titleUsageUnitsWater',
            'waters',
            'rowspanCounts',
            'totalKilowatt',
            'totalCost'
        ));
    }

    public function create()
    {
        $titleUsageUnitsWater = TitleUsageUnitWater::all()->sortBy('location_number_water');

        return view('layouts.admin.forms.invoice_water.invoice-water-create', compact('titleUsageUnitsWater'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'usage_unit_water' => 'required|exists:title_usage_unit_waters,title_usage_unit_water',
            'invoice_number' => 'required|string|max:255',
            'usage_date' => 'required|date',
            'usage_start' => 'nullable|date',
            'usage_end' => 'nullable|date',
            'kilowatt_water' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
        ]);

        // Retrieve the TitleUsageUnitWater model
        $titleUsageUnitWater = TitleUsageUnitWater::where('title_usage_unit_water', $validatedData['usage_unit_water'])->firstOrFail();

        if (!$titleUsageUnitWater) {
            return redirect()->back()->with('error', 'Usage Unit Water not found.');
        }

        // Get the location_number_water
        $locationNumberWater = $titleUsageUnitWater->location_number_water;

        // Create the Water record
        Water::create([
            'usage_unit_water' => $validatedData['usage_unit_water'],
            'location_number_water' => $locationNumberWater, // Ensure this field is stored
            'invoice_number' => $validatedData['invoice_number'],
            'usage_date' => $validatedData['usage_date'],
            'usage_start' => $validatedData['usage_start'] ?? null,
            'usage_end' => $validatedData['usage_end'] ?? null,
            'kilowatt_water' => $validatedData['kilowatt_water'] ?? 0,
            'total_cost' => $validatedData['total_cost'] ?? 0,
        ]);

        return redirect()->route('waters.index')->with('success', 'ថវិការដ្ធករទឹកបានបញ្ចូលដោយជោគជ័យ។');
    }

    public function edit($id)
    {
        $water = Water::findOrFail($id);
        $titleUsageUnitsWater = TitleUsageUnitWater::all();

        return view('layouts.admin.forms.invoice_water.invoice-water-edit', compact('water', 'titleUsageUnitsWater'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'usage_unit_water' => 'required|exists:title_usage_unit_waters,title_usage_unit_water',
            'invoice_number' => 'required|string|max:255',
            'usage_date' => 'required|date',
            'usage_start' => 'nullable|date',
            'usage_end' => 'nullable|date',
            'kilowatt_water' => 'nullable|numeric|min:0',
            'total_cost' => 'nullable|numeric|min:0',
        ]);

        // Retrieve the Water record
        $water = Water::findOrFail($id);

        // Retrieve the TitleUsageUnitWater model
        $titleUsageUnitWater = TitleUsageUnitWater::where('title_usage_unit_water', $validatedData['usage_unit_water'])->first();

        if (!$titleUsageUnitWater) {
            return redirect()->back()->with('error', 'Usage Unit Water not found.');
        }

        // Get the location_number_water
        $locationNumberWater = $titleUsageUnitWater->location_number_water;

        // Update the Water record
        $water->update([
            'usage_unit_water' => $validatedData['usage_unit_water'],
            'location_number_water' => $locationNumberWater, // Ensure this field is updated
            'invoice_number' => $validatedData['invoice_number'],
            'usage_date' => $validatedData['usage_date'],
            'usage_start' => $validatedData['usage_start'] ?? null,
            'usage_end' => $validatedData['usage_end'] ?? null,
            'kilowatt_water' => $validatedData['kilowatt_water'] ?? 0,
            'total_cost' => $validatedData['total_cost'] ?? 0,
        ]);

        return redirect()->route('waters.index')->with('success', 'ថវិការទឹកត្រូវបានកែប្រែដោយជោគជ័យ។');
    }


    public function destroy($id)
    {
        // Find the Electric record by ID
        $waters = Water::findOrFail($id);

        // Delete the record
        $waters->delete();

        // Redirect with a success message
        return redirect()->route('waters.index')->with('success', 'Data deleted successfully.');
    }
}
