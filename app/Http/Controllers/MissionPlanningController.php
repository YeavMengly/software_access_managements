<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MissionPlanningController extends Controller
{

    public function index(){
        return view(''); 
    }


    public function create()
    {
        return view('layouts.admin.forms.form-mission.form-planning-mission'); // Adjust the path as needed
    }
}
