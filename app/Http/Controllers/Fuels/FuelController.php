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

        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $perPage = $request->input('per_page', 25); // Default to 10 if not set


        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('fuel_id', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhere('receipt_number', 'like', "%$search%")
                    ->orWhere('oil_type', 'like', "%$search%") // Added this line
                    ->orWhere('quantity', 'like', "%$search%");
            });
        }

        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('date', [$startDate, $endDate]);
        } elseif (!empty($startDate)) {
            $query->whereDate('date', '>=', $startDate);
        } elseif (!empty($endDate)) {
            $query->whereDate('date', '<=', $endDate);
        }

        $fuels = $query->latest()->paginate($perPage)->appends($request->except('perPage'));


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

        $groupedFuels = collect($fuels->items())->groupBy(function ($fuel) {
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

        $rowspanCounts = [];
        foreach ($fuels as $fuel) {
            $fuelId = $fuel->fuel_id;
            $date = $fuel->date;
            $receiptNumber = $fuel->receipt_number;
            $desc = $fuel->description;

            $rowspanCounts[$fuelId][$date][$receiptNumber][$desc] = ($rowspanCounts[$fuelId][$date][$receiptNumber][$desc] ?? 0) + 1;
        }
        $lastFuelValues = [];

        foreach ($fuels as $fuel) {
            $fuelId = $fuel->fuel_id;
            $oilType = $fuel->oil_type;

            // Check if the oil type exists in the tags
            if ($fuelTags->contains('fuel_tag', $oilType)) {
                $lastFuelValues[$fuelId][$oilType] = [
                    'quantity' => $fuel->quantity,
                    'quantity_used' => $fuel->total,
                    'total' =>  $fuel->quantity - $fuel->total
                ];
            }
        }
        
        return view('layouts.admin.forms.fuels.fuel-index', compact('fuels', 'fuelTags', 'fuelTotalsByDate', 'groupedFuels', 'rowspanCounts', 'lastFuelValues'));
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
        $validated = $request->validate([
            'fuel_id'       => 'required|string|exists:fuel_totals,warehouse_entry_number',
            'date'          => 'required|date',
            'receipt_number' => 'required|string|max:255',
            'description'   => 'nullable|string',
            'oil_type'      => 'required|array',
            'oil_type.*'    => 'required|string',
            'quantity'      => 'required|array',
            'quantity.*'    => 'required|numeric|min:0',
        ]);

        try {

            $fuelTotal = FuelTotal::where('warehouse_entry_number', $validated['fuel_id'])->first();

            if (!$fuelTotal) {
                return redirect()->back()
                    ->withErrors(['fuel_id' => 'លេខបញ្ចូលស្តុកមិនត្រឹមត្រូវទេ។'])
                    ->withInput();
            }

            $usageTotals = [];
            foreach ($validated['oil_type'] as $index => $oilType) {
                if (!isset($usageTotals[$oilType])) {
                    $usageTotals[$oilType] = 0;
                }
                $usageTotals[$oilType] += $validated['quantity'][$index];
            }

            // Check loop 
            foreach ($usageTotals as $oilType => $totalUsed) {
                // 1. Find the matching FuelTotal
                $matchedFuelTotal = FuelTotal::where('warehouse_entry_number', $validated['fuel_id'])
                    ->where('product_name', $oilType)
                    ->first();
                $matchedQuantity = $matchedFuelTotal && is_numeric($matchedFuelTotal->quantity)
                    ? $matchedFuelTotal->quantity
                    : 0;


                // Check validation fuel_id 
                $totalUsedFuel = Fuel::where('fuel_id', $validated['fuel_id'])
                    ->where('oil_type', $oilType)
                    ->where('quantity', $matchedQuantity)
                    ->whereNotNull('quantity_used')
                    ->sum('quantity_used');

                // $totalFuel = $matchedQuantity - $totalUsedFuel;
                $remainingFuel = $matchedQuantity - $totalUsedFuel;

                // ✅ Prevent saving if usage exceeds available fuel
                if ($totalUsed > $remainingFuel) {
                    return redirect()->back()
                        ->withErrors([
                            'quantity' => "ចំនួនសម្រាប់ប្រេង '$oilType' ច្រើនជាងបរិមាណដែលនៅសល់ ($remainingFuel)លីត្រ។"
                        ])
                        ->withInput();
                }

                $fuel = Fuel::create([
                    'fuel_id'        => $validated['fuel_id'],
                    'date'           => $validated['date'],
                    'receipt_number' => $validated['receipt_number'],
                    'description'    => $validated['description'],
                    'oil_type'       => $oilType,
                    'quantity'       => $matchedQuantity,
                    'quantity_used'  => $totalUsed,
                ]);


                // Update fuel total after calculate 
                $fuel->update([
                    'total'          => $remainingFuel - $totalUsed,
                ]);
            }

            return redirect()->route('fuels.index')->with('success', 'ទិន្នន័យបានរក្សាទុកដោយជោគជ័យ។');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['store_error' => 'មានបញ្ហាក្នុងការរក្សាទុកទិន្នន័យ: ' . $e->getMessage()])
                ->withInput();
        }
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

        return redirect()->route('fuels.index')->with('success', 'ប្រេងឥន្ធនៈបានកែប្រែដោយជោគជ័យ');
    }

    /**
     * Remove the specified fuel record from storage.
     */
    public function destroy(Fuel $fuel)
    {
        $fuel->delete();

        return redirect()->route('fuels.index')->with('success', 'ប្រេងឥន្ធនៈបានលុបដោយជោគជ័យ។');
    }
}
