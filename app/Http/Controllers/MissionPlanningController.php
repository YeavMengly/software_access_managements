<?php

namespace App\Http\Controllers;

use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use App\Models\Mission\MissionPlanning;
use App\Models\Mission\MissionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MissionPlanningController extends Controller
{

    public function index(Request $request)
    {
        // Retrieve all mission types for filtering options
        $missionTypes = MissionType::all();
    
        // Get the selected mission type ID from the request
        $selectedMissionType = $request->input('mission_type');
    
        // Query mission planning with relationships
        $query = MissionPlanning::with(['report', 'subAccountKey', 'missionType']);
    
        // Apply filter if a mission type is selected
        if ($selectedMissionType) {
            $query->where('mission_type', $selectedMissionType);
        }
    
        // Fetch the filtered mission plans
        $missionPlannings = $query->get();
    
        // Calculate the total amount for the selected mission type
        $totalAmount = $query->sum('pay_mission');
    
        // Pass data to the view
        return view('layouts.admin.forms.form-mission.form-mission-planning-index', compact('missionPlannings', 'missionTypes', 'selectedMissionType', 'totalAmount'));
    }
    
    

    // Display the form for creating a new mission planning
    public function create()
    {
        $missionTypes = MissionType::all();
        $subAccountKeys = SubAccountKey::all();
        $reports = Report::all();

        return view('layouts.admin.forms.form-mission.form-planning-mission', compact('missionTypes', 'reports', 'subAccountKeys'));
    }

    // Store a new mission planning in the database
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'pay_mission' => 'required|numeric|min:0',
            'mission_type' => 'required|integer|exists:mission_types,id',
        ]);
        // Retrieve the specific report by ID
        $report = Report::with('subAccountKey')->findOrFail($validatedData['report_key']);

        // Check if the report has a related subAccountKey before accessing it
        if ($report->subAccountKey) {
            $subAccountKey = $report->subAccountKey->sub_account_key;
        } else {
            return redirect()->back()->withErrors('SubAccountKey not found for the selected report.');
        }
        MissionPlanning::create([
            'sub_account_key' => $subAccountKey,
            'report_key' => $validatedData['report_key'],
            'pay_mission' => $validatedData['pay_mission'],
            'mission_type' => $validatedData['mission_type'],
        ]);

        return redirect()->route('mission-planning.index')->with('success', 'ផែនការបេសកកម្មបានបង្កើតជោគជ័យ។');
    }



    // Show the form for editing an existing mission planning
    public function edit($id)
    {
        $missionPlanning = MissionPlanning::findOrFail($id);
        $missionTypes = MissionType::all();
        $reports = Report::all();

        return view('layouts.admin.forms.form-mission.form-edit-mission', compact('missionPlanning', 'missionTypes', 'reports'));
    }

    // Update an existing mission planning in the database
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'report_key' => 'required|exists:reports,report_key',
            'pay_mission' => 'required|numeric|min:0',
            'name_mission_type' => 'required|exists:mission_types,name_mission_type',
        ]);

        $missionPlanning = MissionPlanning::findOrFail($id);
        $missionPlanning->update($validatedData);

        return redirect()->route('mission-planning.index')->with('success', 'Mission planning updated successfully.');
    }

    // Delete a mission planning from the database
    public function destroy($id)
    {
        $missionPlanning = MissionPlanning::findOrFail($id);
        $missionPlanning->delete();

        return redirect()->route('mission-planning.index')->with('success', 'Mission planning deleted successfully.');
    }

    public function getEarlyBalance($id)
    {
        $report = Report::find($id);
        $missionPlanning = $report ? $report->missionPlannings : null;

        if ($report) {
            // Calculate credit movement
            $credit_movement = ($missionPlanning->total_increase ?? 0) - ($missionPlanning->decrease ?? 0);

            return response()->json([
                'fin_law' => $report->fin_law,
                'credit_movement' => $credit_movement,
                'new_credit_status' => $report->new_credit_status,
                'credit' => $report->credit,
                'deadline_balance' => $report->deadline_balance,
            ]);
        }

        // Return default values if no report found
        return response()->json([
            'fin_law' => 0,
            'credit_movement' => 0,
            'new_credit_status' => 0,
            'credit' => 0,
            'deadline_balance' => 0,
        ]);
    }
}
