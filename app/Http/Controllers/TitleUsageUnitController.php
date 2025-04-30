<?php

namespace App\Http\Controllers;

use App\Models\Electrics\TitleUsageUnit;
use App\Models\PC\ProvinceCity;
use Illuminate\Http\Request;

class TitleUsageUnitController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 25); // Default to 10 items per page
        $searchTerm = $request->input('search');
        $sortField = $request->input('sort_field', 'title_usage_unit');
        $sortDirection = $request->input('sort_direction', 'asc');

        // Validate sort field
        if (!in_array($sortField, ['title_usage_unit', 'location_number'])) {
            $sortField = 'title_usage_unit';
        }

        $query = TitleUsageUnit::with(['provinceCity']);

        // Search logic
        if ($request->filled('search')) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title_usage_unit', 'like', "%$searchTerm%")
                    ->orWhere('location_number', 'like', "%$searchTerm%")
                    ->orWhereHas('provinceCity', function ($q) use ($searchTerm) {
                        $q->where('title_usage_unit', 'like', "%$searchTerm%");
                    });
            });
        } else {
            foreach (['title_usage_unit', 'location_number'] as $field) {
                if ($request->filled($field)) {
                    $query->where($field, 'like', '%' . $request->input($field) . '%');
                }
            }

            if ($request->filled('province_city')) {
                $query->whereHas('provinceCity', function ($q) use ($request) {
                    $q->where('province_name', 'like', '%' . $request->input('province_city') . '%');
                });
            }
            
        }

        // Apply sorting
        $query->orderBy($sortField, $sortDirection);

        // Fetch paginated results
        $usageUnits = $query->paginate($perPage);

        // Fetch all ProvinceCity data for dropdowns
        $provinceCities = ProvinceCity::all();

        return view('layouts.admin.forms.electric.name_usage_unit.usage_unit', [
            'usageUnits' => $usageUnits,
            'provinceCities' => $provinceCities,
            'perPage' => $perPage,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title_usage_unit' => 'required|string|max:255',
            'location_number' => 'required|string|max:255|unique:title_usage_units,location_number',
            'province_city' => 'required|exists:province_cities,province_city',
        ], [
            'location_number.required' => 'លេខទីតាំង ត្រូវតែបញ្ចូល។',
            'location_number.unique' => 'លេខទីតាំងនេះមានរួចហើយ។',
        ]);

        // Save the title usage unit, using province_city_id as the foreign key
        TitleUsageUnit::create($validatedData);

        return redirect()->route('usage_units.index')->with('success', 'អង្គភាពប្រើប្រាស់បញ្ចូលដោយជោកជ័យ។');
    }

    public function edit(TitleUsageUnit $usageUnit)
    {
        // return response()->json($usageUnit);
    }

    public function update(Request $request, TitleUsageUnit $usageUnit)
    {
        $validated = $request->validate([
            'title_usage_unit' => 'required|string|max:255',
            'location_number' => 'required|string|max:255',
        ]);

        $usageUnit->update($validated);
        return redirect()->route('usage_units.index')->with('success', 'Unit updated successfully.');
    }

    public function destroy(TitleUsageUnit $usageUnit)
    {
        $usageUnit->delete();
        return redirect()->route('usage_units.index')->with('success', 'Unit deleted successfully.');
    }
}
