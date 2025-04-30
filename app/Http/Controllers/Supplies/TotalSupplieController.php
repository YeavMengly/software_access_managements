<?php

namespace App\Http\Controllers\Supplies;

use App\Http\Controllers\Controller;
use App\Models\Supplies\TotalSupplie;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TotalSupplieController extends Controller
{
    //

    // public function index(Request $request)
    // {

    //     $search = $request->input('search');
    //     $startDate = $request->input('start_date');
    //     $endDate = $request->input('end_date');
    //     $query = TotalSupplie::query();

    //     if (!empty($search)) {
    //         $query->where(function ($q) use ($search) {
    //             $q->where('', 'like', "%$search%")
    //                 ->orWhere('', 'like', "%$search%")
    //                 ->orWhere('', 'like', "%$search%")
    //                 ->orWhere('', 'like', "%$search")
    //                 ->orWhere('', 'like', "%$search")
    //                 ->orWhere('', 'like', "%$search");
    //         });
    //     }
    //     if (!empty($startDate) && (!empty($endDate))) {
    //         $query->whereBetween('release_date', [$startDate, $endDate]);
    //     } elseif (!empty($startDate)) {
    //         $query->whereDate('release_date',  '>=', $startDate);
    //     } elseif (!empty($endDate)) {
    //         $query->whereDate('release_date', '>=', $endDate);
    //     }

    //     $totalSupplies = $query->orderBy('created_at', 'desc')->paginate(25);
    //     $sortedCollection = $totalSupplies->getCollection()->sortByDesc('created_at');

    //     $totalSuppliesGrouped = $sortedCollection->groupBy(function ($item) {
    //         return \Carbon\Carbon::parse($item->created_at)->toDateString();
    //     });

    //     $yearlyTotals = [];
    //     foreach ($sortedCollection as $totalSupplie) {
    //         $year = \Carbon\Carbon::parse($totalSupplie->create_at)->format('d-m-Y');

    //         if (!isset($yearlyTotals[$year])) {
    //             $yearlyTotals[$year] = [
    //                 'amount_quantity' => 0,
    //                 'amount_unit_price' => 0,
    //                 'amount_supplie' => 0,
    //             ];
    //         }

    //         $yearlyTotals[$year]['amount_quantity'] += is_numeric($totalSupplie->quantity) ? $totalSupplie->quantity : 0;
    //         $yearlyTotals[$year]['amount_unit_price'] += is_numeric($totalSupplie->unit_price) ? $totalSupplie->unit_price : 0;
    //         $yearlyTotals[$year]['amount_supplie'] += is_numeric($totalSupplie->total_price) ? $totalSupplie->total_price : 0;
    //     }

    //     return view('layouts.admin.forms.supplies.total-supplies.total_supplies', ['totalSupplies' => $totalSupplies, 'yearlyTotals' => $yearlyTotals, 'totalSuppliesGrouped' => $totalSuppliesGrouped]);
    // }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $query = TotalSupplie::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%$search%")
                    ->orWhere('warehouse', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhere('refers', 'like', "%$search%")
                    ->orWhere('product_name', 'like', "%$search%")
                    ->orWhere('source', 'like', "%$search%");
            });
        }

        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('release_date', [$startDate, $endDate]);
        } elseif (!empty($startDate)) {
            $query->whereDate('release_date', '>=', $startDate);
        } elseif (!empty($endDate)) {
            $query->whereDate('release_date', '<=', $endDate); // small fix here too
        }

        $totalSupplies = $query->orderBy('created_at', 'desc')->paginate(25);
        $sortedCollection = $totalSupplies->getCollection()->sortByDesc('created_at');

        $totalSuppliesGrouped = $sortedCollection->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->created_at)->toDateString();
        });

        $yearlyTotals = [];
        foreach ($sortedCollection as $totalSupplie) {
            $year = \Carbon\Carbon::parse($totalSupplie->created_at)->format('d-m-Y');

            if (!isset($yearlyTotals[$year])) {
                $yearlyTotals[$year] = [
                    'amount_quantity' => 0,
                    'amount_unit_price' => 0,
                    'amount_supplie' => 0,
                ];
            }

            $yearlyTotals[$year]['amount_quantity'] += is_numeric($totalSupplie->quantity) ? $totalSupplie->quantity : 0;
            $yearlyTotals[$year]['amount_unit_price'] += is_numeric($totalSupplie->unit_price) ? $totalSupplie->unit_price : 0;
            $yearlyTotals[$year]['amount_supplie'] += is_numeric($totalSupplie->total_price) ? $totalSupplie->total_price : 0;
        }

        return view('layouts.admin.forms.supplies.total-supplies.total_supplies', [
            'totalSupplies' => $totalSupplies,
            'yearlyTotals' => $yearlyTotals,
            'totalSuppliesGrouped' => $totalSuppliesGrouped
        ]);
    }


    public function store(Request $request)
    {
        try {
            // If product_name is an array (from multiple inputs), join it into a string
            $productNames = $request->input('product_name');
            $joinedProductName = is_array($productNames) ? implode("\n", $productNames) : $productNames;

            // Merge back into the request before validation
            $request->merge(['product_name' => $joinedProductName]);

            $validated  = $request->validate([
                'company_name' => 'required|string|max:255',
                'release_date' => 'required|date',
                'refers' => 'nullable|string',
                'description' => 'required|string|max:255',
                'warehouse' => 'required|string|max:255',
                'product_name' => 'required|string',        // រាយមុខទំនិញ
                'unit' => 'required|string|max:255',
                'quantity' => 'required|integer|min:0',     // បរិមាណ
                'unit_price' => 'required|numeric|min:0',   // តម្លៃឯកតា
                'source' => 'required|string|max:255',      // ប្រភព
                'production_year' => 'required|date'        // ឆ្នាំផលិត
            ]);

            // Calculate total price
            $totalPrice = $validated['quantity'] * $validated['unit_price'];

            // Save to database
            TotalSupplie::create(array_merge($validated, ['total_price' => $totalPrice]));

            return redirect()->route('supplie-totals.index')->with('success', 'សម្ភារបានរក្សាទុកដោយជោគជ័យ។');
        } catch (\Exception $e) {
            Log::error($e); // Optional: log error to storage/logs/laravel.log

            return redirect()->back()
                ->withErrors(['store_error' => 'មានបញ្ហាក្នុងការរក្សាទុកទិន្នន័យ : ' . $e->getMessage()])
                ->withInput();
        }
    }
    public function edit(TotalSupplie $totalSupplie)
    {
        return view('layouts.admin.forms.supplies.total-supplies.total_supplies_edit', compact('totalSupplie'));
    }

    public function update(Request $request, TotalSupplie $totalSupplie)
    {
        try {
            $productNames = $request->input('product_name');
            $joinedProductName = is_array($productNames) ? implode("\n", $productNames) : $productNames;
            $request->merge(['product_name' => $joinedProductName]);

            $validated = $request->validate([
                'company_name' => 'required|string|max:255',
                'release_date' => 'required|date',
                'refers' => 'nullable|string',
                'description' => 'required|string|max:255',
                'warehouse' => 'required|string|max:255',
                'product_name' => 'required|string',
                'unit' => 'required|string|max:255',
                'quantity' => 'required|integer|min:0',
                'unit_price' => 'required|numeric|min:0',
                'source' => 'required|string|max:255',
                'production_year' => 'required|date'
            ]);

            $totalPrice = $validated['quantity'] * $validated['unit_price'];

            // ✅ No need to find again
            $totalSupplie->update(array_merge($validated, ['total_price' => $totalPrice]));

            return redirect()->route('supplie-totals.index')->with('success', 'ទិន្នន័យត្រូវបានកែប្រែជោគជ័យ។');
        } catch (\Exception $e) {
            Log::error($e);

            return redirect()->back()
                ->withErrors(['update_error' => 'មានបញ្ហាក្នុងការកែប្រែទិន្នន័យ: ' . $e->getMessage()])
                ->withInput();
        }
    }


    public function destroy($id)
    {
        try {
            $supplie = TotalSupplie::findOrFail($id);
            $supplie->delete();

            return redirect()->route('supplie-totals.index')->with('success', 'ទិន្នន័យត្រូវបានលុបដោយជោគជ័យ។');
        } catch (\Exception $e) {
            Log::error($e);

            return redirect()->back()->withErrors(['delete_error' => 'មានបញ្ហាក្នុងការលុបទិន្នន័យ: ' . $e->getMessage()]);
        }
    }
}
