<?php

namespace App\Http\Controllers\Code;

use App\Http\Controllers\Controller;
use App\Models\Code\AccountKey;
use Illuminate\Http\Request;
use App\Models\Code\Key;

class AccountKeyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'account_key');
        $sortOrder = $request->input('sort_order', 'asc');
        $perPage = $request->input('per_page', 25);

        $query = AccountKey::query();

        if ($search) {
            $query->where('account_key', 'like', '%' . $search . '%')
                ->orWhere('name_account_key', 'like', '%' . $search . '%')
                ->orWhereHas('key', function ($q) use ($search) {
                    $q->where('code', 'like', '%' . $search . '%');
                });
        }

        if ($sortBy === 'key.code') {
            $query->join('keys', 'account_keys.code_id', '=', 'keys.id')
                ->orderBy('keys.code', $sortOrder)
                ->select('account_keys.*');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $accountKeys = $query->paginate($perPage); 

        // Fetch sorted keys based on user's selection
        $keys = Key::orderBy('code', $sortOrder)->get();

        return view('layouts.admin.forms.accounts.account-index', compact('accountKeys', 'keys', 'sortBy', 'sortOrder'));
    }




    public function create()
    {
        $keys = Key::all();
        return view('layouts.admin.forms.accounts.account-create', compact('keys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:keys,id',
            'account_key' => 'required',
            'name_account_key' => 'required',
        ]);

        // Check if the combination of code_id and account_key already exists
        $existingRecord = AccountKey::where('code', $request->code)
            ->where('account_key', $request->account_key)
            ->first();

        if ($existingRecord) {
            // If the combination of code_id and account_key exists, return with an error
            return redirect()->back()->withErrors([
                'account_key' => 'The combination of code and account key already exists.'
            ])->withInput();
        }

        // Create the new record if the combination is unique
        AccountKey::create($request->only('code', 'account_key', 'name_account_key'));

        return redirect()->route('accounts.index')->with('success', 'លេខគណនីបានបង្កើតដោយជោគជ័យ។');
    }




    public function show($id)
    {
        $accountKey = AccountKey::findOrFail($id);
        return view('layouts.admin.forms.accounts.account-show', compact('accountKey'));
    }

    public function edit($id)
    {
        $accountKey = AccountKey::findOrFail($id);
        $keys = Key::all();
        return view('layouts.admin.forms.accounts.account-edit', compact('accountKey', 'keys'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|exists:keys,id',
            'account_key' => 'required',
            'name_account_key' => 'required',
        ]);

        // Check if the combination of code and account_key already exists for another record
        $existingRecord = AccountKey::where('code', $request->code) // Adjusted to 'code'
            ->where('account_key', $request->account_key)
            ->where('id', '<>', $id)
            ->first();

        if ($existingRecord) {
            // If the combination of code and account_key exists for another record, return with an error
            return redirect()->back()->withErrors([
                'account_key' => 'The combination of code and account key already exists.'
            ])->withInput();
        }

        $accountKey = AccountKey::findOrFail($id);
        $accountKey->update($request->only('code', 'account_key', 'name_account_key')); // Adjusted to 'code'

        return redirect()->route('accounts.index')->with('success', 'លេខគណនីបានកែប្រែដោយជោគជ័យ។');
    }



    public function destroy($id)
    {
        $accountKey = AccountKey::findOrFail($id);
        $accountKey->delete();
        return redirect()->route('accounts.index')->with('success', 'Account Key deleted successfully.');
    }
}
