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
        $sort = $request->input('sort', 'sub_account_key'); 
        $direction = $request->input('direction', 'asc');
        $perPage = $request->input('per_page', 25);
        $validColumns = ['code', 'account_key', 'sub_account_key'];

        if (!in_array($sort, $validColumns)) {
            $sort = 'sub_account_key';
        }

        $query = SubAccountKey::with('accountKey.key');

        if ($search) {
            $query->whereHas('accountKey.key', function ($q) use ($search) {
                $q->where('code', 'like', '%' . $search . '%');
            })
                ->orWhereHas('accountKey', function ($q) use ($search) {
                    $q->where('account_key', 'like', '%' . $search . '%');
                })
                ->orWhere('sub_account_key', 'like', '%' . $search . '%');
        }

        if ($sort === 'code') {
            $query->join('account_keys', 'sub_account_keys.account_key_id', '=', 'account_keys.id')
                ->join('keys', 'account_keys.key_id', '=', 'keys.id')
                ->orderBy('keys.code', $direction)
                ->select('sub_account_keys.*');
        } elseif ($sort === 'account_key') {
            $query->join('account_keys', 'sub_account_keys.account_key_id', '=', 'account_keys.id')
                ->orderBy('account_keys.account_key', $direction);
        } elseif ($sort === 'sub_account_key') {
            $query->orderBy('sub_account_keys.sub_account_key', $direction);
        }
        $subAccountKeys = $query->paginate($perPage); 

        return view('layouts.admin.forms.sub_accounts.sub-account-index', compact('subAccountKeys'));
    }

    public function create()
    {
        $accountKeys = AccountKey::with('key')->get();
        $subAccountKeys = SubAccountKey::with('accountKey.key')->get(); 

        return view('layouts.admin.forms.sub_accounts.sub-account-create', compact('accountKeys', 'subAccountKeys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_key' => 'required|exists:account_keys,account_key',
            'sub_account_key' => 'required',
            'name_sub_account_key' => 'required'
        ]);

        $existingRecord = SubAccountKey::where('account_key', $request->input('account_key'))
            ->where('sub_account_key', $request->input('sub_account_key'))
            ->first();

        if ($existingRecord) {
            return redirect()->back()->withErrors([
                'sub_account_key' => 'The combination of Account Key and Sub-Account Key already exists.'
            ])->withInput();
        }

        SubAccountKey::create([
            'account_key' => $request->input('account_key'),
            'sub_account_key' => $request->input('sub_account_key'),
            'name_sub_account_key' => $request->input('name_sub_account_key')
        ]);

        return redirect()->route('sub-account.index')->with('success', 'លេខអនុគណនីបានបង្កើតដោយជោគជ័យ។');
    }

    public function show($id)
    {
        $subAccountKey = SubAccountKey::with('accountKey.key')->findOrFail($id);

        return view('layouts.admin.forms.sub_accounts.sub-account-show', compact('subAccountKey'));
    }
    
    public function edit($id)
    {
        $subAccountKey = SubAccountKey::findOrFail($id);
        $accountKeys = AccountKey::with('key')->get();

        return view('layouts.admin.forms.sub_accounts.sub-account-edit', compact('subAccountKey', 'accountKeys'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'account_key' => 'required|exists:account_keys,id',
            'sub_account_key' => 'required',
            'name_sub_account_key' => 'required'
        ]);

        $existingRecord = SubAccountKey::where('account_key', $request->input('account_key'))
            ->where('sub_account_key', $request->input('sub_account_key'))
            ->where('id', '<>', $id) 
            ->first();

        if ($existingRecord) {
            return redirect()->back()->withErrors([
                'sub_account_key' => 'អនុគណនីបានបញ្ចូលរួចរាល់។'
            ])->withInput();
        }

        $subAccountKey = SubAccountKey::findOrFail($id);
        $subAccountKey->update([
            'account_key' => $request->input('account_key'),
            'sub_account_key' => $request->input('sub_account_key'),
            'name_sub_account_key' => $request->input('name_sub_account_key')
        ]);

        return redirect()->route('sub-account.index')->with('success', 'លេខអនុគណនីបានកែដោយជោគជ័យ។');
    }

    public function destroy($id)
    {
        $subAccountKey = SubAccountKey::findOrFail($id);
        $subAccountKey->delete();

        return redirect()->route('sub-account.index')->with('success', 'លេខអនុគណនីបានលុបដោយជោគជ័យ។');
    }
}
