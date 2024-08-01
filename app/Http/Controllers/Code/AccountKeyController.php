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

        $accountKeys = $query->paginate(10);

        return view('layouts.admin.forms.accounts.account-index', compact('accountKeys', 'sortBy', 'sortOrder'));
    }



    public function create()
    {
        $keys = Key::all();
        return view('layouts.admin.forms.accounts.account-create', compact('keys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code_id' => 'required|exists:keys,id',
            'account_key' => 'required',
            'name_account_key' => 'required'
        ]);

        $existingAccountKey = AccountKey::where('code_id', $request->input('code_id'))
            ->where('account_key', $request->input('account_key'))
            ->where('name_account_key', $request->input('name_account_key'))
            ->first();

        if ($existingAccountKey) {
            return redirect()->back()->with('error', 'The account key already exists.');
        }

        AccountKey::create([
            'code_id' => $request->input('code_id'),
            'account_key' => $request->input('account_key'),
            'name_account_key' => $request->input('name_account_key')
        ]);

        return redirect()->route('accounts.index')->with('success', 'Account Key created successfully.');
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
            'code_id' => 'required|exists:keys,id',
            'account_key' => 'required',
            'name_account_key' => 'required'
        ]);

        $accountKey = AccountKey::findOrFail($id);
        $accountKey->update([
            'code_id' => $request->input('code_id'),
            'account_key' => $request->input('account_key'),
            'name_account_key' => $request->input('name_account_key')
        ]);

        return redirect()->route('accounts.index')->with('success', 'Account Key updated successfully.');
    }

    public function destroy($id)
    {
        $accountKey = AccountKey::findOrFail($id);
        $accountKey->delete();
        return redirect()->route('accounts.index')->with('success', 'Account Key deleted successfully.');
    }
}
