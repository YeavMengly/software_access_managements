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
        $missionTypes = MissionType::all();
        $selectedMissionType = $request->input('mission_type');
        $subAccountKeyId = $request->input('sub_account_key_id');
        $reportKey = $request->input('report_key');
        $sortField = $request->input('sort_field', 'value_mandate');
        $sortDirection = $request->input('sort_direction', 'asc');
        $perPage = $request->input('per_page', 25);
    
        if (!in_array($sortField, ['value_mandate', 'report_key'])) {
            $sortField = 'value_mandate';
        }
    
        $query = Mandate::with(['dataMandate.subAccountKey.accountKey.key', 'missionType'])
            ->whereHas('dataMandate.year', function ($query) {
                $query->where('status', 'active');
            })
            ->when($subAccountKeyId, function ($query, $subAccountKeyId) {
                $query->whereHas('dataMandate.subAccountKey', function ($query) use ($subAccountKeyId) {
                    $query->where('sub_account_key', 'like', "%{$subAccountKeyId}%");
                });
            })
            ->when($reportKey, function ($query, $reportKey) {
                $query->whereHas('dataMandate', function ($query) use ($reportKey) {
                    $query->where('report_key', 'like', "%{$reportKey}%");
                });
            })
            ->when($selectedMissionType, function ($query, $selectedMissionType) {
                $query->where('mission_type', $selectedMissionType);
            });
    
        $mandates = $query->orderBy($sortField, $sortDirection)->paginate($perPage);
        $totalAmount = $query->sum('value_mandate');
    
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
        $validatedData = $request->validate([
            'report_key' => 'required|exists:data_mandates,id',
            'value_mandate' => 'required|numeric|min:0',
            'mission_type' => 'required|exists:mission_types,id',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf|max:2048',
            'date_mandate' => 'required|date',
        ]);

        $dataMandate = DataMandate::findOrFail($validatedData['report_key']);
        if (!$dataMandate || !$dataMandate->subAccountKey) {
            return redirect()->back()->withErrors(['error' => 'មិនមាន អនុគណនី ឬកូដកម្មវិធី។']);
        }
        $applyValue = $validatedData['value_mandate'];
        $remainingCredit = $dataMandate->credit - $applyValue;

        if ($remainingCredit < 0) {
            return redirect()->back()->withErrors(['error' => 'ឥណាទានមិនអាចតិចជាងសូន្យ។']);
        }

        $storedFilePaths = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file->isValid()) {
                    $filePath = $file->store('mandates', 'public');
                    $storedFilePaths[] = $filePath;
                }
            }
        }
        Mandate::create([
            'report_key' => $validatedData['report_key'],
            'value_mandate' => $applyValue,
            'mission_type' => $validatedData['mission_type'],
            'attachments' => json_encode($storedFilePaths),
            'date_mandate' => $validatedData['date_mandate'],

        ]);

        $this->calculateAndSaveReportWithMandate($dataMandate);

        $dataMandate->refresh();
        $lastMandate = Mandate::where('report_key', $validatedData['report_key'])->latest()->first();
        $dataMandate->apply = $lastMandate->value_mandate;
        $dataMandate->save();

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
        } else {
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
            'report_key' => 'required|exists:data_mandates,id',
            'value_mandate' => 'required|numeric|min:0',
            'mission_type' => 'required|exists:mission_types,id',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf|max:2048',
            'date_mandate' => 'required|date',
        ]);
    
        $mandate = Mandate::findOrFail($id); // Find the specific mandate by ID
        $dataMandate = DataMandate::findOrFail($validatedData['report_key']);
    
        if (!$dataMandate || !$dataMandate->subAccountKey) {
            return redirect()->back()->withErrors(['error' => 'មិនមាន អនុគណនី ឬកូដកម្មវិធី។']);
        }
    
        $applyValue = $validatedData['value_mandate'];
        $remainingCredit = $dataMandate->credit - $applyValue + $mandate->value_mandate;
    
        if ($remainingCredit < 0) {
            return redirect()->back()->withErrors(['error' => 'ឥណាទានមិនអាចតិចជាងសូន្យ។']);
        }
    
        // Handle attachments
        $storedFilePaths = $mandate->attachments ? json_decode($mandate->attachments, true) : [];
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
            'value_mandate' => $applyValue,
            'mission_type' => $validatedData['mission_type'],
            'attachments' => json_encode($storedFilePaths),
            'date_mandate' => $validatedData['date_mandate'],
        ]);
    
        $this->calculateAndSaveReportWithMandate($dataMandate);
    
        $dataMandate->refresh();
        $lastMandate = Mandate::where('report_key', $validatedData['report_key'])->latest()->first();
        $dataMandate->apply = $lastMandate->value_mandate;
        $dataMandate->save();
    
        return redirect()->back()->with('success', 'អាណត្តិបានកែប្រែដោយជោគជ័យ');
    }
    
    public function destroy($id)
    {
        $mandate = Mandate::findOrFail($id);
        $dataMandate = DataMandate::findOrFail($mandate->report_key);

        $mandate->delete();

        $newApplyTotal = Mandate::where('report_key', $dataMandate->id)->sum('value_mandate');
        $dataMandate->apply = $newApplyTotal > 0 ? $newApplyTotal : 0;
        $dataMandate->deadline_balance = $dataMandate->early_balance + $dataMandate->apply;

        $credit = $dataMandate->new_credit_status - $dataMandate->deadline_balance;
        $dataMandate->update([
            'credit' => $credit,
            'apply' => $dataMandate->apply,
            'deadline_balance' => $dataMandate->deadline_balance,
        ]);

        $this->calculateAndSaveReportWithMandate($dataMandate);

        return redirect()->route('mandates.index')->with('success', 'អាណត្តិបានលុបដោយជោគជ័យ។');
    }
    private function calculateAndSaveReportWithMandate(DataMandate $dataMandate)
    {
        $newApplyTotal = Mandate::where('report_key', $dataMandate->id)
            ->latest('created_at')
            ->value('value_mandate') ?? 0;
        $dataMandate->early_balance = $this->calculateEarlyBalance($dataMandate);

        $dataMandate->apply = $newApplyTotal;
        $credit = $dataMandate->new_credit_status - $dataMandate->deadline_balance;
        $dataMandate->credit = $credit;
        $dataMandate->deadline_balance = $dataMandate->early_balance + $dataMandate->apply;
        $dataMandate->credit = $dataMandate->new_credit_status - $dataMandate->deadline_balance;
        $dataMandate->law_average = $dataMandate->deadline_balance > 0 ? ($dataMandate->deadline_balance / $dataMandate->fin_law) * 100 : 0;
        $dataMandate->law_correction =  $dataMandate->deadline_balance > 0 ? ($dataMandate->deadline_balance /  $dataMandate->new_credit_status) * 100 : 0;
        $dataMandate->save();
    }

    private function calculateEarlyBalance($dataMandate)
    {
        $mandate = Mandate::where('report_key', $dataMandate->id)->get();

        if ($mandate->count() === 1) {
            return 0;
        }

        $totalEarlyBalance = $mandate->slice(0, -1)
            ->filter(function ($item) {
                return !is_null($item->value_mandate) && $item->value_mandate !== '';
            })
            ->sum('value_mandate');

        return $totalEarlyBalance ?: 0;
    }
}
