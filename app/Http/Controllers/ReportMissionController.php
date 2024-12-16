<?php

namespace App\Http\Controllers;

use App\Models\ImportedMissionData;
use Illuminate\Http\Request;
use App\Models\ReportMissionCambodia;
use Exception;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ReportMissionController extends Controller
{
    // Method to display the report-mission table with data
    public function index()
    {
        // Example data to be displayed in the form
        $data = [
            ['id_number' => '1751200142', 'name_khmer' => 'ហេង សួរ', 'name_latin' => 'HENG SOUR', 'account_number' => '0010002560009', 'total_amount' => 0],
            ['id_number' => '1690500036', 'name_khmer' => 'ឡាវ ហ៊ីម', 'name_latin' => 'LAOV HIM', 'account_number' => '0010002543888', 'total_amount' => 0],
            ['id_number' => '1720800864', 'name_khmer' => 'ឡេង សេ', 'name_latin' => 'LENG SE', 'account_number' => '0010002722602', 'total_amount' => 0],
            ['id_number' => '1651200111', 'name_khmer' => 'គុយ រតនា', 'name_latin' => 'KUY ROTTANA', 'account_number' => '0010002528385', 'total_amount' => 0],
        ];
        // Pass the data to the view
        return view('layouts.table.table-mission.report-mission', compact('data'));
    }

    // Store mission data from the form
    public function storeMission(Request $request)
    {
        // Validate form input
        $validatedData = $request->validate([
            'missions.*.id_number' => 'required|string|max:255',
            'missions.*.name_khmer' => 'required|string|max:255',
            'missions.*.name_latin' => 'required|string|max:255',
            'missions.*.account_number' => 'required|string|max:255',
            'missions.*.total_amount' => 'required|numeric',
        ]);

        // Loop through each mission data and save it
        foreach ($validatedData['missions'] as $mission) {
            ReportMissionCambodia::create([
                'id_number' => $mission['id_number'],
                'name_khmer' => $mission['name_khmer'],
                'name_latin' => $mission['name_latin'],
                'account_number' => $mission['account_number'],
                'total_amount' => $mission['total_amount'],
            ]);
        }

        // Redirect back with success message
        return redirect()->route('report-mission')->with('success', 'Mission data has been successfully saved.');
    }

    public function import(Request $request)
    {
        // Validate that a file is uploaded and it's in a valid format
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        // Retrieve the uploaded file
        $file = $request->file('file');

        try {
            // Load the spreadsheet using PhpSpreadsheet's IOFactory
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();

            // Iterate through each row in the spreadsheet
            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false); // Loop through all cells, even empty ones

                $rowData = [];
                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue(); // Collect the cell data
                }

                // Prepare the data to be saved in the ImportedMissionData table
                $importedData = [
                    'id_number' => $rowData[0],       // For 'ល.រ'
                    'name_khmer' => $rowData[1],      // For 'ឈ្មោះ - ខ្មែរ'
                    'name_latin' => $rowData[2],      // For 'ឈ្មោះ - ឡាតាំង'
                    'account_number' => $rowData[3],  // For 'លេខគណនី'
                ];

                // Store the data in the ImportedMissionData table
                ImportedMissionData::create($importedData);
            }

            // Redirect to the view page and show a success message
            return redirect()->route('layouts.table.table-mission.imported-mission-table')->with('success', 'Data imported successfully.');
        } catch (Exception $e) {
            // Log the error and return an error message to the user
            Log::error('Error loading file: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'There was an error importing the file.']);
        }
    }

    public function importedMissionTable()
    {
        // Retrieve the data if needed and pass it to the view
        $importedData = ImportedMissionData::all();
        // dd($importedData); 

        return view('layouts.table.table-mission.imported-mission-table', compact('importedData'));
    }
}
