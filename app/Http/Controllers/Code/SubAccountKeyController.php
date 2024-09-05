<?php

namespace App\Http\Controllers\Code;

use App\Http\Controllers\Controller;
use App\Models\Code\AccountKey;
use App\Models\Code\SubAccountKey;
use Illuminate\Http\Request;

class SubAccountKeyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'sub_account_key'); // Default sorting by 'sub_account_key'
        $direction = $request->input('direction', 'asc'); // Default direction is 'asc'

        // Define valid columns for sorting
        $validColumns = ['code', 'account_key', 'sub_account_key'];
        if (!in_array($sort, $validColumns)) {
            $sort = 'sub_account_key'; // Fallback to default if invalid column
        }

        $query = SubAccountKey::with('accountKey.key');

        // Apply search filter
        if ($search) {
            $query->whereHas('accountKey.key', function ($q) use ($search) {
                $q->where('code', 'like', '%' . $search . '%');
            })
                ->orWhereHas('accountKey', function ($q) use ($search) {
                    $q->where('account_key', 'like', '%' . $search . '%');
                })
                ->orWhere('sub_account_key', 'like', '%' . $search . '%');
        }

        // Handle sorting based on related columns
        if ($sort === 'code') {
            $query->join('account_keys', 'sub_account_keys.account_key_id', '=', 'account_keys.id')
                ->join('keys', 'account_keys.key_id', '=', 'keys.id')
                ->orderBy('keys.code', $direction)
                ->select('sub_account_keys.*'); // Include sub_account_keys fields
        } elseif ($sort === 'account_key') {
            $query->join('account_keys', 'sub_account_keys.account_key_id', '=', 'account_keys.id')
                ->orderBy('account_keys.account_key', $direction);
        } elseif ($sort === 'sub_account_key') {
            $query->orderBy('sub_account_keys.sub_account_key', $direction);
        }

        $subAccountKeys = $query->paginate(); // Adjust pagination as needed

        return view('layouts.admin.forms.sub_accounts.sub-account-index', compact('subAccountKeys'));
    }




    public function create()
    {
        $accountKeys = AccountKey::with('key')->get();
        $subAccountKeys = SubAccountKey::with('accountKey.key')->get(); // Eager load sub-account keys and their related account keys and keys

        return view('layouts.admin.forms.sub_accounts.sub-account-create', compact('accountKeys', 'subAccountKeys'));
    }


    public function show($id)
    {
        $subAccountKey = SubAccountKey::with('accountKey.key')->findOrFail($id);

        return view('layouts.admin.forms.sub_accounts.sub-account-show', compact('subAccountKey'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'account_key' => 'required|exists:account_keys,id',
            'sub_account_key' => 'required',
            'name_sub_account_key' => 'required'
        ]);
    
        // Check if the combination of account_key_id and sub_account_key already exists
        $existingRecord = SubAccountKey::where('account_key', $request->input('account_key'))
                                       ->where('sub_account_key', $request->input('sub_account_key'))
                                       ->first();
    
        if ($existingRecord) {
            // If the combination exists, return with an error message
            return redirect()->back()->withErrors([
                'sub_account_key' => 'The combination of Account Key and Sub-Account Key already exists.'
            ])->withInput();
        }
    
        // Create the new record if the combination is unique
        SubAccountKey::create([
            'account_key' => $request->input('account_key'),
            'sub_account_key' => $request->input('sub_account_key'),
            'name_sub_account_key' => $request->input('name_sub_account_key')
        ]);
    
        return redirect()->route('sub-account.index')->with('success', 'លេខអនុគណនីបានបង្កើតដោយជោគជ័យ។');
    }
    

    public function edit($id)
    {
        $subAccountKey = SubAccountKey::findOrFail($id);
        $accountKeys = AccountKey::with('key')->get(); // Fetch all account keys to populate the dropdown

        return view('layouts.admin.forms.sub_accounts.sub-account-edit', compact('subAccountKey', 'accountKeys'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'account_key' => 'required|exists:account_keys,id',
            'sub_account_key' => 'required',
            'name_sub_account_key' => 'required'
        ]);

        $subAccountKey = SubAccountKey::findOrFail($id);
        $subAccountKey->update([
            'account_key' => $request->input('account_key'),
            'sub_account_key' => $request->input('sub_account_key'),
            'name_sub_account_key' => $request->input('name_sub_account_key')
        ]);

        return redirect()->route('sub-account.index')->with('success', 'Sub-Account Key updated successfully.');
    }


    public function destroy($id)
    {
        $subAccountKey = SubAccountKey::findOrFail($id);
        $subAccountKey->delete();

        return redirect()->route('sub-account.index')->with('success', 'Sub-Account Key deleted successfully.');
    }
}
