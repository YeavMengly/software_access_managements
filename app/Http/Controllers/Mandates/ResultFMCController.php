<?php

namespace App\Http\Controllers\Mandates;

use App\Http\Controllers\Controller;
use App\Models\Code\Report;
use App\Models\DataMandate;
use Illuminate\Http\Request;

class ResultFMCController extends Controller
{
    //
    public function index()
    {
        // Fetch data mandates with relationships
        $dataMandates = DataMandate::with(['mandate', 'subAccountKey'])->get();

        // Extract and format the required data
        $formattedMandates = $dataMandates->map(function ($mandate) {
            return [
                'sub_account_key' => $mandate->subAccountKey->sub_account_key ?? null,
                'report_key' => $mandate->report_key,
                'apply' => number_format($mandate->apply ?? 0, 0, ' ', ' '),
                'mandate_details' => $mandate->mandate->value_mandate ?? null, // Example of accessing mandate details
            ];
        });

        return view('layouts.table.fmc.result-fin-mandate-certificate', compact('formattedMandates'));
    }
}
