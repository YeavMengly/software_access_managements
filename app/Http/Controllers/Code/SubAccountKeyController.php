<?php

namespace App\Http\Controllers\Code;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubAccountKeyController extends Controller
{
    //
    public function index (){
        return view('layouts.admin.forms.sub_accounts.sub-account-index');
    }

    public function create(){
        return view('layouts.admin.forms.sub_accounts.sub-account-create');
    }
}
