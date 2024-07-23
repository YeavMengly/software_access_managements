<?php

namespace App\Http\Controllers\Code;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountKeyController extends Controller
{
    //
    public function index (){
        return view('layouts.admin.forms.accounts.account-index');
        
    }

    public function create (){
        return view('layouts.admin.forms.accounts.account-create');
    }
}
