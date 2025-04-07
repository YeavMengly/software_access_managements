<?php

namespace App\Http\Controllers\Fuels;

use App\Http\Controllers\Controller;
use App\Models\Fuels\Fuel;
use App\Models\Fuels\FuelTag;
use App\Models\Fuels\FuelTotal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FuelController extends Controller
{
    /**
     * Display a listing of the fuel records.
     */

    public function index(Request $request)
    {
        $query = Fuel::query();
        $fuelTags = FuelTag::all();

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        if ($request->filled('receipt_number')) {
            $query->where('receipt_number', 'LIKE', '%' . $request->receipt_number . '%');
        }

        if ($request->filled('description')) {
            $query->where('description', 'LIKE', '%' . $request->description . '%');
        }

        if ($request->has('fuel_date') && !empty($request->fuel_date)) {
            $date = Carbon::parse($request->fuel_date)->format('Y-m-d');
            $query->whereDate('created_at', $date);
        }

        $fuels = $query->latest()->get();
        $fuelTotal = FuelTotal::latest()->first();
        $fuelTotals = FuelTotal::latest()->get();

        $quantities = [];
        if ($fuelTotal) {
            foreach ($fuelTotal->fuels as $fuel) {
                $fuelQuantities = is_string($fuel->quantity)
                    ? json_decode($fuel->quantity, true)
                    : $fuel->quantity;

                if (!is_array($fuelQuantities)) {
                    $fuelQuantities = [$fuelQuantities];
                }
                foreach ($fuelQuantities as $qty) {
                    $quantities[] = $qty;
                }
            }
        }

        $groupedFuels = $fuels->groupBy(function ($fuel) {
            return implode('|', [
                $fuel->fuel_date,
                $fuel->date,
                $fuel->receipt_number,
                $fuel->description,
                json_encode($fuel->oil_type),
                json_encode($fuel->quantity),
            ]);
        });

        $fuelTotalsByDate = $fuelTotals->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('Y-m-d');
        });

        return view('layouts.admin.forms.fuels.fuel-index', compact('fuels', 'fuelTags', 'fuelTotalsByDate', 'groupedFuels'));
    }

    /**
     * Show the form for creating a new fuel record.
     */
    public function create()
    {

        $fuelData = FuelTotal::select('release_date', 'warehouse_entry_number')
            ->groupBy('warehouse_entry_number', 'release_date')
            ->orderBy('warehouse_entry_number', 'desc')
            ->get();
        $fuelTags = FuelTag::all();

        return view('layouts.admin.forms.fuels.fuel-create', compact('fuelTags', 'fuelData'));
    }

    /**
     * Store a newly created fuel record in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'fuel_id' => 'required|exists:fuel_totals,id', // Check the 'id' of the fuel_total
            'date' => 'required|date',
            'receipt_number' => 'required|string|unique:fuels',
            'description' => 'nullable|string',
            'oil_type' => 'required|array',
            'oil_type.*' => 'string',
            'quantity' => 'required|array',
            'quantity.*' => 'numeric|min:0',
        ]);

        if (count($validated['oil_type']) !== count($validated['quantity'])) {
            return redirect()->back()->withErrors(['error' => 'Oil type and quantity count mismatch.']);
        }

        // Retrieve the FuelTotal entry based on the selected fuel_id
        $fuelTotal = FuelTotal::find($validated['fuel_id']);

        if (!$fuelTotal) {
            return redirect()->back()->withErrors(['error' => 'Fuel Total not found.']);
        }

        // Decode fuelTotal quantity if stored as JSON
        $fuelTotalQuantity = is_array($fuelTotal->quantity) ?
            $fuelTotal->quantity : json_decode($fuelTotal->quantity, true);

        if (!is_array($fuelTotalQuantity)) {
            $fuelTotalQuantity = [];
        }

        // Ensure that `quantity_used` is stored directly without summing previous values
        Fuel::create([
            'fuel_id' => $validated['fuel_id'], // Store the selected fuel_id directly
            'date' => $validated['date'],
            'receipt_number' => $validated['receipt_number'],
            'description' => $validated['description'],
            'fuel_total_id' => $fuelTotal->id, // Store the related fuel_total_id
            'oil_type' => $validated['oil_type'], // Store entire oil_type array
            'quantity' => $fuelTotalQuantity, // Store indexed array of quantity
            'quantity_used' => $validated['quantity'], // Directly store without summing
        ]);

        return redirect()->route('fuels.index')->with('success', 'Fuel record created successfully.');
    }

    /**
     * Show the form for editing the specified fuel record.
     */
    public function edit(Fuel $fuel)
    {
        return view('layouts.admin.forms.fuels.fuel-edit', compact('fuel'));
    }

    /**
     * Update the specified fuel record in storage.
     */
    public function update(Request $request, Fuel $fuel)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'receipt_number' => 'required|string|unique:fuels,receipt_number,' . $fuel->id,
            'description' => 'nullable|string',
            'oil_type' => 'required|array',
            'oil_type.*' => 'string',
            'quantity' => 'required|array',
            'quantity.*' => 'numeric|min:0',
        ]);

        $fuel->update($validated);

        return redirect()->route('fuels.index')->with('success', 'Fuel record updated successfully.');
    }

    /**
     * Remove the specified fuel record from storage.
     */
    public function destroy(Fuel $fuel)
    {
        $fuel->delete();

        return redirect()->route('fuels.index')->with('success', 'Fuel record deleted successfully.');
    }
}
