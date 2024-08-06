<?php

namespace App\Http\Controllers\Code;

use App\Http\Controllers\Controller;
use App\Models\Code\Key;
use Illuminate\Http\Request;

class KeyController extends Controller
{
    //

    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'code');
        $sortOrder = $request->input('sort_order', 'asc');
    
        $query = Key::query();
    
        // Apply search filter
        if ($search) {
            $query->where('code', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%");
        }
    
        // Apply sorting
        if ($sortBy === 'code') {
            $query->orderBy('code', $sortOrder);
        } else if ($sortBy === 'name') {
            $query->orderBy('name', $sortOrder);
        }
    
        $keys = $query->paginate(10);
    
        return view('layouts.admin.forms.keys.key-index', compact('keys', 'sortBy', 'sortOrder', 'search'));
    }
    


    public function create()
    {
        $keys = Key::all();
        return view('layouts.admin.forms.keys.key-create', compact('keys'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required'
        ]);

        // Check if the code already exists
        $existingCode = Key::where('code', $request->code)->first();

        if ($existingCode) {
            // If the code already exists, redirect back with an error message
            return redirect()->back()->withErrors(['code' => 'The code has already been inputted.'])->withInput();
        }

        // Create the new record if the code does not exist
        Key::create($request->only('code', 'name'));

        return redirect()->route('keys.index')->with('success', 'Code created successfully.');
    }


    public function show($id)
    {
        $key = Key::findOrFail($id);
        return view('layouts.admin.forms.keys.key-show', compact('key'));
    }

    public function edit($id)
    {
        $key = Key::findOrFail($id);
        return view('layouts.admin.forms.keys.key-edit', compact('key'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required'
        ]);

        $key = Key::findOrFail($id);
        $key->update($request->only('code', 'name'));

        return redirect()->route('keys.index')->with('success', 'Code updated successfully.');
    }

    public function destroy($id)
    {
        $key = Key::findOrFail($id);
        $key->delete();

        return redirect()->route('keys.index')->with('success', 'Code deleted successfully.');
    }
}
