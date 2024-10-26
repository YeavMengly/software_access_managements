<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ReportCambodiaImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Map rows to your data structure
        return $rows->map(function ($row) {
            return [
                'id_number' => $row[0],
                'name_khmer' => $row[1],
                'name_latin' => $row[2],
                'account_number' => $row[3],
            ];
        });
    }
}
