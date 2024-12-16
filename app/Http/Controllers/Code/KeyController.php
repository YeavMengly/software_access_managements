<?php

namespace App\Http\Controllers\Code;

use App\Http\Controllers\Controller;
use App\Models\Code\Key;
use Illuminate\Http\Request;

class KeyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'code');
        $sortOrder = $request->input('sort_order', 'asc');
        $perPage = $request->input('per_page', 25);
        $query = Key::query();

        if ($search) {
            $query->where('code', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%");
        }

        if ($sortBy === 'code') {
            $query->orderBy('code', $sortOrder);
        } elseif ($sortBy === 'name') {
            $query->orderBy('name', $sortOrder);
        }
        $keys = $query->paginate($perPage); 

        return view('layouts.admin.forms.keys.key-index', compact('keys', 'sortBy', 'sortOrder', 'search'));
    }

    public function create()
    {
        return view('layouts.admin.forms.keys.key-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:keys,code',
            'name' => 'required|unique:keys,name',
        ]);

        Key::create($request->only('code', 'name'));

        return redirect()->route('keys.index')->with('success', 'លេខជំពូកបានបង្កើតដោយជោគជ័យ។');
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
        $key = Key::findOrFail($id);

        $request->validate([
            'code' => 'required|unique:keys,code,' . $key->id,
            'name' => 'required|unique:keys,name,' . $key->id,
        ]);

        $key->update($request->only('code', 'name'));

        return redirect()->route('keys.index')->with('success', 'លេខជំពូកបានកែដោយជោគជ័យ។');
    }

    public function destroy($id)
    {
        $key = Key::findOrFail($id);
        $key->delete();

        return redirect()->route('keys.index')->with('success', 'លេខជំពូកបានលុបដោយជោគជ័យ។');
    }
}
