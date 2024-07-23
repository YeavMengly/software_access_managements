<?php

namespace App\Http\Controllers\Code;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    //

    public function index(){
        return view('layouts.admin.forms.keys.key-index'); 
    }

    public function create (){
        return view('layouts.admin.forms.keys.key-create');
    }
}
