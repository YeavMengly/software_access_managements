<?php

namespace App\Http\Controllers;

use App\Models\Electrics\Electric;
use App\Models\Electrics\TitleUsageUnit;
use App\Models\PC\ProvinceCity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ElectricController extends Controller
{
    public function index(Request $request)
    {
        // Create query builder for Electric model
        $query = Electric::query();

        // Search by usage_unit or location_number
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('usage_unit', 'like', '%' . $searchTerm . '%')
                    ->orWhere('location_number', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by start_date and end_date with validation
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

            if ($startDate->greaterThan($endDate)) {
                return redirect()->back()->with('error', 'Start date must be before end date.');
            }

            // Apply the date range filter to the query
            $query->whereBetween('usage_date', [$startDate, $endDate]);
        }

        // **Auto-sort by location_number**
        $query->orderBy('location_number', 'asc');

        // Paginate the results
        $electrics = $query->paginate(10);

        // Fetch related data
        $titleUsageUnits = TitleUsageUnit::all();
        $provinceCities = ProvinceCity::all();

        // Count occurrences for rowspan logic
        $rowspanCounts = [];
        foreach ($electrics as $electric) {
            $location = $electric->location_number;
            $unit = $electric->usage_unit;
            $createdYear = Carbon::parse($electric->created_at)->format('Y');

            $rowspanCounts[$location][$unit][$createdYear] = ($rowspanCounts[$location][$unit][$createdYear] ?? 0) + 1;
        }

        // Return view with results
        return view('layouts.admin.forms.electric.electric-index', compact(
            'electrics',
            'provinceCities',
            'titleUsageUnits',
            'rowspanCounts'
        ));
    }

    public function create()
    {
        $titleUsageUnits = TitleUsageUnit::all()->sortBy('location_number');

        return view('layouts.admin.forms.electric.electric-create', compact('titleUsageUnits'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'usage_unit' => 'required|exists:title_usage_units,title_usage_unit',
            'usage_date' => 'required|date',
            'usage_start' => 'nullable|date',
            'usage_end' => 'nullable|date',
            'kilowatt_energy' => 'nullable|numeric|min:0',
            'reactive_energy' => 'nullable|numeric|min:0',
            'total_amount' => 'nullable|numeric|min:0',
        ]);

        // Retrieve the location_number from the TitleUsageUnit model based on usage_unit
        $titleUsageUnit = TitleUsageUnit::where('title_usage_unit', $validatedData['usage_unit'])->first();

        // Ensure that the location_number exists in the retrieved model
        if ($titleUsageUnit) {
            $locationNumber = $titleUsageUnit->location_number;
        } else {
            return redirect()->back()->with('error', 'Usage Unit not found.');
        }

        // Create the new Electric record with the validated data and the location_number
        Electric::create([
            'usage_unit' => $validatedData['usage_unit'],
            'usage_date' => $validatedData['usage_date'],
            'usage_start' => $validatedData['usage_start'] ?? null,
            'usage_end' => $validatedData['usage_end'] ?? null,
            'kilowatt_energy' => $validatedData['kilowatt_energy'] ?? 0,
            'reactive_energy' => $validatedData['reactive_energy'] ?? 0,
            'total_amount' => $validatedData['total_amount'] ?? 0,
            'location_number' => $locationNumber,  // Add the location_number here
        ]);

        // Redirect back with success message
        return redirect()->route('electrics.index')->with('success', 'ថវិការអគ្គិសនីបានបញ្ចូលដោយជោគជ័យ។');
    }

    public function edit($id)
    {
        $electric = Electric::findOrFail($id);

        // dd($electric);
        $titleUsageUnits = TitleUsageUnit::all()->sortBy('location_number');

        return view('layouts.admin.forms.electric.electric-edit', compact('electric', 'titleUsageUnits'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'usage_unit' => 'required|exists:title_usage_units,title_usage_unit',
            'usage_date' => 'required|date',
            'usage_start' => 'nullable|date',
            'usage_end' => 'nullable|date',
            'kilowatt_energy' => 'nullable|numeric|min:0',
            'reactive_energy' => 'nullable|numeric|min:0',
            'total_amount' => 'nullable|numeric|min:0',
        ]);

        // Retrieve the existing Electric record
        $electric = Electric::findOrFail($id);

        // Retrieve the location_number from the TitleUsageUnit model based on usage_unit
        $titleUsageUnit = TitleUsageUnit::where('title_usage_unit', $validatedData['usage_unit'])->first();

        if (!$titleUsageUnit) {
            return redirect()->back()->with('error', 'Usage Unit not found.');
        }


        $updates = [
            'usage_unit' => 'required|exists:title_usage_units,title_usage_unit',
            'usage_date' => 'required|date',
            'usage_start' => 'nullable|date',
            'usage_end' => 'nullable|date',
            'kilowatt_energy' => 'nullable|numeric|min:0',
            'reactive_energy' => 'nullable|numeric|min:0',
            'total_amount' => 'nullable|numeric|min:0',
        ];

        // if ($electric->isClean($updates)) {
        //     return redirect()->route('electrics.index')->with('info', 'មិនមានការផ្លាស់ប្តូរទិន្នន័យទេ។');
        // }

        // Update the Electric record with new data
        $electric->update([
            'usage_unit' => $validatedData['usage_unit'],
            'usage_date' => $validatedData['usage_date'],
            'usage_start' => $validatedData['usage_start'] ?? null,
            'usage_end' => $validatedData['usage_end'] ?? null,
            'kilowatt_energy' => $validatedData['kilowatt_energy'] ?? 0,
            'reactive_energy' => $validatedData['reactive_energy'] ?? 0,
            'total_amount' => $validatedData['total_amount'] ?? 0,
            'location_number' => $titleUsageUnit->location_number, // Update location_number
        ]);

        // if ($electric->isClean($updates)) {
        //     return redirect()->route('electrics.index')->with('info', 'មិនមានការផ្លាស់ប្តូរទិន្នន័យទេ។');
        // }

        // Redirect back with success message
        return redirect()->route('electrics.index')->with('success', 'ថវិការអគ្គិសនីបានកែប្រែដោយជោគជ័យ។');
    }

    public function destroy($id)
    {
        // Find the Electric record by ID
        $electric = Electric::findOrFail($id);

        // Delete the record
        $electric->delete();

        // Redirect with a success message
        return redirect()->route('electric.index')->with('success', 'Data deleted successfully.');
    }
}
