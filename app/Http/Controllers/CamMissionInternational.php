<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CamMissionInternational extends Controller
{
    /**
     * Display the table for Cambodia International missions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch data for the table
        $missions = []; // Replace this with actual data fetching logic

        // Return the view with the missions data
        return view('layouts.table.table-mission.table-mission-cam-international');
    }
}