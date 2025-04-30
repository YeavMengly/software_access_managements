<?php

namespace App\Http\Controllers\Supllies;

use App\Http\Controllers\Controller;
use App\Models\Supplies\Supplie;
use App\Models\Supplies\TotalSupplie;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SupplieController extends Controller
{
    //
    public function index()
    {
       $supplie = Supplie::all();

        dd($supplie);
        return view('layouts.admin.forms.supplies.supplie-index');
    }

    public function create()
    {

        $totalSupplie = TotalSupplie::select('release_date')
            ->groupBy('release_date')
            ->get();
        return view('layouts.admin.forms.supplies.supplie-create', compact('totalSupplie'));
    }

    // public function store(Request $request)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'supplie_id' => 'required|date|exists:total_supplies,release_date',
    //             'date' => 'required|date',
    //             'receipt_number' => 'required|string|max:255',
    //             'description' => 'required|string',
    //             'unit' => 'required|string|max:255',
    //             'quantity_used' => 'required|numeric|min:0',
    //         ]);

    //         $totalSupplie = TotalSupplie::where('release_date', $validated['supplie_id'])->first();

    //         if (!$totalSupplie) {
    //             return redirect()->back()
    //                 ->withErrors(['supplie_id' => 'លេខបញ្ចូលស្តុកមិនត្រឹមត្រូវទេ។'])
    //                 ->withInput();
    //         }

    //         $usageTotals = [];
    //         foreach ($validated['description'] as $desc) {
    //             if (!isset($usageTotals[$desc])) {
    //                 $usageTotals[$desc] = 0;
    //             }
    //             $usageTotals[$desc] += $validated['quantity'];
    //         }

    //         foreach ($usageTotals as $desc => $totalUsed) {

    //             $matchedQuantity = $totalSupplie && is_numeric($totalSupplie->quantity) ? $totalSupplie->quantity : 0;

    //             $totalUsedSupplie = Supplie::where('supplie_id', $validated['supplie_id'])
    //                 ->where('quantity', $matchedQuantity)
    //                 ->whereNotNull('quantity_used')
    //                 ->sum('quantity_used');


    //             // Calculate remain
    //             $remain_supplie = $matchedQuantity - $totalUsedSupplie;


    //             if ($totalUsed > $remain_supplie) {
    //                 return redirect()->back()->withErrors([
    //                     'quantity' => "ចំនួនសម្រាប់សម្ភារច្រើនជាងបរិមាណដែលនៅសល់ ($remain_supplie)លីត្រ។"
    //                 ])->withInput();
    //                 # code...
    //             }

    //             $supplie = Supplie::create([
    //                 'supplie_id' => $validated['supplie_id'],
    //                 'date' => $validated['date'],
    //                 'receipt_number' => $validated['receipt_number'],
    //                 'description' => $validated['description'],
    //                 'unit' => $validated['unit'],
    //                 'quantity_used' => $totalUsed
    //             ]);

    //             // Update Supplie Remain after calculate 
    //             $supplie->update([
    //                 'remain_supplie' => $remain_supplie - $totalUsed
    //             ]);;
    //         }

    //         return redirect()->route('supplies.index')->with('success', 'សម្ភារៈបានបង្កើតដោយជោគជ័យ');
    //     } catch (\Exception $e) {
    //         Log::error($e);

    //         return redirect()->back()
    //             ->withErrors(['store_error' => 'មានបញ្ហាក្នុងការរក្សាទុកទិន្នន័យ : ' . $e->getMessage()])
    //             ->withInput();
    //     }
    // }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'supplie_id' => 'required|date|exists:total_supplies,release_date',
                'date' => 'required|date',
                'receipt_number' => 'required|string|max:255',
                'description' => 'required|string',
                'unit' => 'required|string|max:255',
                'quantity_used' => 'required|numeric|min:0',
            ]);

            $totalSupplie = TotalSupplie::where('release_date', $validated['supplie_id'])->first();

            if (!$totalSupplie) {
                return redirect()->back()
                    ->withErrors(['supplie_id' => 'លេខបញ្ចូលស្តុកមិនត្រឹមត្រូវទេ។'])
                    ->withInput();
            }

            $matchedQuantity = is_numeric($totalSupplie->quantity) ? $totalSupplie->quantity : 0;

            $totalUsedSupplie = Supplie::where('supplie_id', $validated['supplie_id'])
                ->where('description', $validated['description'])
                ->whereNotNull('quantity_used')
                ->sum('quantity_used');

            $remain_supplie = $matchedQuantity - $totalUsedSupplie;

            if ($validated['quantity_used'] > $remain_supplie) {
                return redirect()->back()->withErrors([
                    'quantity_used' => "ចំនួនសម្រាប់សម្ភារច្រើនជាងបរិមាណដែលនៅសល់ ($remain_supplie) លីត្រ។"
                ])->withInput();
            }

            $supplie = Supplie::create([
                'supplie_id' => $validated['supplie_id'],
                'date' => $validated['date'],
                'receipt_number' => $validated['receipt_number'],
                'description' => $validated['description'],
                'unit' => $validated['unit'],
                'quantity' => $matchedQuantity,
                'quantity_used' => $validated['quantity_used'],
                'remain_supplie' => $remain_supplie - $validated['quantity_used'],
            ]);

            // $supplie->update([
            //     'remain_supplie' => $remain_supplie - $validated['quantity_used'],
            // ]);

            return redirect()->route('supplies.index')->with('success', 'សម្ភារៈបានបង្កើតដោយជោគជ័យ');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()
                ->withErrors(['store_error' => 'មានបញ្ហាក្នុងការរក្សាទុកទិន្នន័យ : ' . $e->getMessage()])
                ->withInput();
        }
    }
}
