<?php

namespace App\Http\Controllers\Mandates;

use App\Http\Controllers\Controller;
use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use App\Models\DataMandate;
use App\Models\Mandates\Mandate;
use App\Models\Mission\MissionType;
use Illuminate\Http\Request;

class MandateController extends Controller
{
    //
    public function index(Request $request)
    {
        // Retrieve all mission types for filtering options
        $missionTypes = MissionType::all();

        // Get the selected mission type ID from the request
        $selectedMissionType = $request->input('mission_type');

        // Query mission planning with relationships
        $query = Mandate::with(['dataMandate', 'subAccountKey', 'missionType']);

        // Apply filter if a mission type is selected
        if ($selectedMissionType) {
            $query->where('mission_type', $selectedMissionType);
        }

        // Fetch the filtered mission plans
        $mandates = $query->get();

        // Calculate the total amount for the selected mission type
        $totalAmount = $query->sum('value_mandate');

        // Pass data to the view
        return view('layouts.admin.forms.mandate.mandate-index', compact('mandates', 'missionTypes', 'selectedMissionType', 'totalAmount'));
    }

    public function create()
    {
        $missionTypes = MissionType::all();
        $subAccountKeys = SubAccountKey::all();
        $dataMandate = DataMandate::all();

        return view('layouts.admin.forms.mandate.mandate-create', compact('missionTypes', 'dataMandate', 'subAccountKeys'));
    }

    public function store(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'report_key' => 'required|exists:data_mandates,id',
            'value_mandate' => 'required|numeric|min:0',
            'mission_type' => 'required|exists:mission_types,id',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf|max:2048',
            'date_mandate' => 'required|date',

        ]);

        // Retrieve the report by the provided report_key
        $dataMandate = DataMandate::findOrFail($validatedData['report_key']);
        if (!$dataMandate || !$dataMandate->subAccountKey) {
            return redirect()->back()->withErrors(['error' => 'មិនមាន អនុគណនី ឬកូដកម្មវិធី។']);
        }
        $applyValue = $validatedData['value_mandate'];
        $remainingCredit = $dataMandate->credit - $applyValue;

        if ($remainingCredit < 0) {
            return redirect()->back()->withErrors(['error' => 'ឥណាទានមិនអាចតិចជាងសូន្យ។']);
        }

        // Initialize array for storing file paths
        $storedFilePaths = [];

        // Process uploaded files
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file->isValid()) {
                    // Store file and save the file path in the database
                    $filePath = $file->store('mandates', 'public'); // Save to public storage
                    $storedFilePaths[] = $filePath;  // Store the file path
                }
            }
        }

        // Store data in the database
        Mandate::create([
            'report_key' => $validatedData['report_key'],
            'value_mandate' => $applyValue,
            'mission_type' => $validatedData['mission_type'],
            'attachments' => json_encode($storedFilePaths),  // Store the file paths as JSON
            'date_mandate' => $validatedData['date_mandate'],

        ]);

        $this->calculateAndSaveReportWithMandate($dataMandate);
        return redirect()->back()->with('success', 'អាណត្តិបានបញ្ចូលដោយជោគជ័យ');
    }

    public function getEarlyBalance($id)
    {
        $dataMandate = DataMandate::find($id); 
        $loan = $dataMandate ? $dataMandate->loans : null;

        if ($dataMandate) {
            $credit_movement = ($loan->total_increase ?? 0) - ($loan->decrease ?? 0);
            return response()->json([
                'fin_law' => $dataMandate->fin_law,
                'credit_movement' =>  $credit_movement,
                'new_credit_status' => $dataMandate->new_credit_status,
                'credit' => $dataMandate->credit,
                'deadline_balance' => $dataMandate->deadline_balance,
            ]);
        }
        else {
            return response()->json([
                'error' => 'DataMandate not found.'
            ], 404);
        }

        return response()->json([
            'fin_law' => 0,
            'credit_movement' => 0,
            'new_credit_status' => 0,
            'credit' => 0,
            'deadline_balance' => 0,
        ]);
    }

    public function edit($id)
    {
        $mandate = Mandate::findOrFail($id);
        $missionTypes = MissionType::all();
        $subAccountKeys = SubAccountKey::all();
        $dataMandate = DataMandate::all();

        return view('layouts.admin.forms.mandate.mandate-edit', compact('mandate', 'missionTypes', 'dataMandate', 'subAccountKeys'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'report_key' => 'required|exists:reports,id',
            'value_mandate' => 'required|numeric|min:0',
            'mission_type' => 'required|exists:mission_types,id',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf|max:2048',
        ]);

        $mandate = Mandate::findOrFail($id);

        $dataMandate = DataMandate::where('id', $validatedData['report_key'])
            ->whereHas('year', function ($query) {
                $query->where('status', 'active');
            })
            ->firstOrFail();
        $storedFilePaths = json_decode($mandate->attachments, true) ?? [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file->isValid()) {
                    $filePath = $file->store('mandates', 'public');
                    $storedFilePaths[] = $filePath;
                }
            }
        }

        $mandate->update([
            'report_key' => $validatedData['report_key'],
            'value_mandate' => $validatedData['value_mandate'],
            'mission_type' => $validatedData['mission_type'],
            'attachments' => json_encode($storedFilePaths),  // Store the file paths as JSON
        ]);
        return redirect()->route('mandates.index')->with('success', 'Mandate updated successfully.');
    }

    public function destroy($id)
    {
        $mandate = Mandate::findOrFail($id);
        $dataMandate = DataMandate::findOrFail($mandate->report_key);
    
        // Delete the mandate
        $mandate->delete();
    
        // Calculate new totals and balances
        $newApplyTotal = Mandate::where('report_key', $dataMandate->id)->sum('value_mandate');
        $dataMandate->apply = $newApplyTotal > 0 ? $newApplyTotal : 0;
        $dataMandate->deadline_balance = $dataMandate->early_balance + $dataMandate->apply;
    
        $credit = $dataMandate->new_credit_status - $dataMandate->deadline_balance;
        $dataMandate->update([
            'credit' => $credit,
            'apply' => $dataMandate->apply,
            'deadline_balance' => $dataMandate->deadline_balance,
        ]);
    
        // Recalculate related data
        $this->calculateAndSaveReportWithMandate($dataMandate);
    
        return redirect()->route('mandates.index')->with('success', 'អាណត្តិបានលុបដោយជោគជ័យ។');
    }
    
    private function calculateAndSaveReportWithMandate(DataMandate $dataMandate)
    {
        $lastValue = Mandate::where('report_key', $dataMandate->id)->sum('value_mandate');
        $dataMandate->apply = $lastValue;
        $credit = $dataMandate->new_credit_status - $dataMandate->deadline_balance;
        $dataMandate->credit = $credit;
        $dataMandate->deadline_balance = $dataMandate->early_balance + $dataMandate->apply;
        $dataMandate->credit = $dataMandate->new_credit_status - $dataMandate->deadline_balance;
        $dataMandate->law_average = $dataMandate->deadline_balance > 0 ? ($dataMandate->deadline_balance / $dataMandate->fin_law) * 100 : 0;
        $dataMandate->law_correction = $dataMandate->deadline_balance > 0 ? ($dataMandate->deadline_balance /  $dataMandate->new_credit_status) * 100 : 0;
        $dataMandate->save();
    }
}
