<?php

namespace App\Http\Controllers\Fuels;

use App\Http\Controllers\Controller;
use App\Models\Fuels\FuelTag;
use App\Models\Fuels\FuelTotal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FuelTotalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $fuelTags = FuelTag::all();
        $query = FuelTotal::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhere('refers', 'like', "%$search%")
                    ->orWhere('warehouse_entry_number', 'like', "%$search%")
                    ->orWhereRaw("JSON_CONTAINS(product_name, '\"$search\"')")
                    ->orWhereRaw("JSON_CONTAINS(quantity, '\"$search\"')")
                    ->orWhereRaw("JSON_CONTAINS(unit_price, '\"$search\"')");
            });
        }

        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('release_date', [$startDate, $endDate]);
        } elseif (!empty($startDate)) {
            $query->whereDate('release_date', '>=', $startDate);
        } elseif (!empty($endDate)) {
            $query->whereDate('release_date', '<=', $endDate);
        }

        $fuelTotals = $query->orderBy('created_at', 'desc')->paginate(10);
        $sortedCollection = $fuelTotals->getCollection()->sortByDesc('created_at');

        $fuelTotalsGrouped = $sortedCollection->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->created_at)->toDateString();
        });

        $yearlyTotals = [];

        foreach ($sortedCollection as $fuelTotal) {
            $year = \Carbon\Carbon::parse($fuelTotal->created_at)->format('d-m-Y');

            if (!isset($yearlyTotals[$year])) {
                $yearlyTotals[$year] = [
                    'total_quantity' => 0,
                    'total_unit_price' => 0,
                    'total_fuel_total' => 0
                ];
            }

            $yearlyTotals[$year]['total_quantity'] += is_array($fuelTotal->quantity) ? array_sum($fuelTotal->quantity) : 0;
            $yearlyTotals[$year]['total_unit_price'] += is_array($fuelTotal->unit_price) ? array_sum($fuelTotal->unit_price) : 0;
            $yearlyTotals[$year]['total_fuel_total'] += is_array($fuelTotal->fuel_total) ? array_sum($fuelTotal->fuel_total) : 0;
        }

        $rowspanCounts = [];
        foreach ($fuelTotals as $fuelTotal) {
            $createdYear = Carbon::parse($fuelTotal->created_at)->format('Y');
            $rowspanCounts[$createdYear] = ($rowspanCounts[$createdYear] ?? 0) + 1;
        }

        $descriptionRowspanCounts = [];
        foreach ($sortedCollection as $fuelTotal) {
            $createdYear = Carbon::parse($fuelTotal->created_at)->format('Y');
            $desc = $fuelTotal->description;
            $warehouseEntry = $fuelTotal->warehouse_entry_number;
            $companyName = $fuelTotal->company_name;
            $refers = $fuelTotal->refers;
            $releaseDate = $fuelTotal->release_date;
            $warehouse = $fuelTotal->warehouse;
            $key = $createdYear . '|' . $desc . '|' . $warehouseEntry . '|' . $companyName . '|' . $refers . '|' . $releaseDate . '|' . $warehouse;
            if (!isset($descriptionRowspanCounts[$key])) {
                $descriptionRowspanCounts[$key] = 0;
            }
            $descriptionRowspanCounts[$key]++;
        }

        return view('layouts.admin.forms.fuels.fuel-total.fuel_total', [
            'fuelTotals' => $fuelTotals,
            'fuelTotalsGrouped' => $fuelTotalsGrouped,
            'yearlyTotals' => $yearlyTotals,
            'rowspanCounts' => $rowspanCounts,
            'descriptionRowspanCounts' => $descriptionRowspanCounts,
            'fuelTags' => $fuelTags
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'release_date' => 'required|date',
            'refers' => 'nullable|string',
            'description' => 'required|string|max:255',
            'warehouse_entry_number' => 'required|string|max:255',
            'warehouse' => 'required|string|max:255',
            'product_name' => 'required|array',
            'product_name.*' => 'required|string|max:255',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:0',
            'unit_price' => 'required|array',
            'unit_price.*' => 'required|numeric|min:0',
        ]);

        foreach ($request->product_name as $index => $product) {
            $quantity = $request->quantity[$index];
            $unit_price = $request->unit_price[$index];
            $fuel_total = $quantity * $unit_price;

            FuelTotal::create([
                'company_name' => $request->company_name,
                'release_date' => $request->release_date,
                'refers' => $request->refers,
                'description' => $request->description,
                'warehouse_entry_number' => $request->warehouse_entry_number,
                'warehouse' => $request->warehouse,
                'product_name' => $product,
                'quantity' => $quantity,
                'unit_price' => $unit_price,
                'fuel_total' => $fuel_total,
            ]);
        }

        return redirect()->route('fuel-totals.index')->with('success', 'ការបន្ថែមទិន្នន័យសម្រេចបានដោយជោគជ័យ');
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'company_name' => 'required|string|max:255',
            'release_date' => 'required|date',
            'refers' => 'nullable|string',
            'description' => 'required|string|max:255',
            'warehouse_entry_number' => 'required|string|max:255',
            'warehouse' => 'required|string|max:255',
            'product_name' => 'required|array',
            'product_name.*' => 'required|string|max:255',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:0',
            'unit_price' => 'required|array',
            'unit_price.*' => 'required|numeric|min:0',
        ]);

        // Calculate fuel totals for each item
        $quantities = $request->quantity;
        $unit_prices = $request->unit_price;
        $fuel_totals = [];

        foreach ($quantities as $index => $qty) {
            $fuel_totals[] = $qty * $unit_prices[$index];
        }

        // Find the record to update
        $fuelTotalRecord = FuelTotal::findOrFail($id);

        // Update the record with the new data
        $fuelTotalRecord->update([
            'company_name' => $request->company_name,
            'release_date' => $request->release_date,
            'refers' => $request->refers,
            'description' => $request->description,
            'warehouse_entry_number' => $request->warehouse_entry_number,
            'warehouse' => $request->warehouse,
            'product_name' => $request->product_name,
            'quantity' => $quantities,
            'unit_price' => $unit_prices,
            'fuel_total' => $fuel_totals,
        ]);

        return redirect()->route('fuel-totals.index')->with('success', 'ការកែប្រែទិន្នន័យសម្រេចបានដោយជោគជ័យ');
    }


    public function destroy(FuelTotal $fuelTotal)
    {
        $fuelTotal->delete();
        return redirect()->route('fuel-totals.index')->with('success', 'ប្រេងឥន្ធនៈសរុបបានលុបដោយជោគជ័យ');
    }

    public function exportPdf() {}
}
