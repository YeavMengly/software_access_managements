<?php

namespace App\Http\Controllers\Components;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TotalProgramsController extends Controller
{
    //
    public function index(){
        return view('layouts.components.programs');
    }
}
