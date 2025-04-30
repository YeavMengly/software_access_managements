<?php

namespace App\Http\Controllers\Waters;

use App\Http\Controllers\Controller;
use App\Models\PC\ProvinceCity;
use App\Models\Waters\TitleUsageUnitWater;
use Illuminate\Http\Request;

class TitleUsageUnitWaterController extends Controller
{
    //
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10); // Default to 10 items per page
        $query = TitleUsageUnitWater::query();

        // Combined single search field
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title_usage_unit_water', 'like', "%$searchTerm%")
                    ->orWhere('location_number_water', 'like', "%$searchTerm%")
                    ->orWhereHas('provinceCity', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', "%$searchTerm%");
                    });
            });
        } else {
            foreach (['title_usage_unit_water', 'location_number_water', 'province_city'] as $field) {
                if ($request->filled($field)) {
                    $query->where($field, 'like', '%' . $request->input($field) . '%');
                }
            }
        }

        // Paginate with dynamic perPage value
        $usageUnitsWater = $query->paginate($perPage);
        $provinceCities = ProvinceCity::all(); // Fetch all ProvinceCity data

        return view('layouts.admin.forms.invoice_water.name_usage_unit_water.usage_unit_water', [
            'usageUnitsWater' => $usageUnitsWater,
            'provinceCities' => $provinceCities, // Pass to the view
            'perPage' => $perPage, // Pass perPage to the view
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title_usage_unit_water' => 'required|string|max:255',
            'location_number_water' => 'required|string|max:255|unique:title_usage_unit_waters,location_number_water',
            'province_city' => 'required|exists:province_cities,province_city',
        ], [
            'location_number.required' => 'លេខទីតាំង ត្រូវតែបញ្ចូល។',
            'location_number.unique' => 'លេខទីតាំងនេះមានរួចហើយ។',
        ]);

        // Save the title usage unit, using province_city_id as the foreign key
        TitleUsageUnitWater::create($validatedData);

        return redirect()->route('usage_units_water.index')->with('success', 'អង្គភាពប្រើប្រាស់បញ្ចូលដោយជោកជ័យ។');
    }

    public function edit(TitleUsageUnitWater $usageUnit)
    {
        // return response()->json($usageUnit);
    }

    public function update(Request $request, TitleUsageUnitWater $titleUsageUnitWater)
    {
        $validatedData = $request->validate([
            'title_usage_unit' => 'required|string|max:255',
            'location_number' => 'required|string|max:255',
        ]);

        $titleUsageUnitWater->update($validatedData);
        return redirect()->route('usage_units_water.index')->with('success', 'Unit updated successfully.');
    }

    public function destroy(TitleUsageUnitWater $titleUsageUnitWater)
    {
        $titleUsageUnitWater->delete();
        return redirect()->route('usage_units_water.index')->with('success', 'Unit deleted successfully.');
    }
}
