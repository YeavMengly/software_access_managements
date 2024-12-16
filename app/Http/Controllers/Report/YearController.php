<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Code\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function index(Request $request)
    {
        $query = Year::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->where('date_year', 'LIKE', '%' . $request->search . '%');
        }

        $years = $query->get();
        return view('layouts.admin.date_year.date_year_index', compact('years'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            // If not an admin, redirect or show an error
            return redirect()->route('years.index')->with('error', 'You are not authorized to create a year.');
        }

        $currentYear = now()->year;
        $request->validate([
            'date_year' => [
                'required',
                'string',
                'date_format:Y',
                'unique:years,date_year',
                function ($attribute, $value, $fail) {
                    $currentYear = now()->year;
                    if ((string)$value < $currentYear) {
                        $fail("You cannot create past years. The current year is $currentYear.");
                    }
                },
            ],
        ], [
            'date_year.unique' => 'This year already exists. Please enter a different year.',
        ]);

        $inputYear = (string)$request->input('date_year');
        $currentYear = now()->year;
        $status = $inputYear >= $currentYear ? 'active' : 'inactive';

        Year::create([
            'date_year' => $inputYear . '-01-01',
            'status' => $status,
        ]);

        return redirect()->route('years.index')->with('success', 'Year created successfully!');
    }

    public function edit(Year $year)
    {
        return view('layouts.admin.date_year.edit', compact('year'));
    }

    public function update(Request $request, Year $year)
    {
        $validatedData = $request->validate([
            'date_year' => 'required|string'
        ]);

        $validatedData['date_year'] = $validatedData['date_year'] . '-01-01';

        $year->update($validatedData);

        return redirect()->route('years.index')->with('success', 'ឆ្នាំបានកែប្រែដោយជោគជ័យ!');
    }

    public function destroy($id)
    {
        $year = Year::findOrFail($id);
        $year->delete();

        return redirect()->route('years.index')->with('success', 'Year deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $year = Year::findOrFail($id);
    
        if (auth()->user()->role === 'admin') {

            $year->status = $year->status === 'active' ? 'inactive' : 'active';
            $year->save();
    
            return response()->json(['status' => $year->status, 'success' => true]);
        }
    
        return response()->json(['error' => 'Unauthorized', 'success' => false], 403);
    }
}
