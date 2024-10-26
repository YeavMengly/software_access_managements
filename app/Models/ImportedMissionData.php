<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportedMissionData extends Model
{
    use HasFactory;

    // Specify the table name if it's not the default 'imported_mission_data'
    protected $table = 'report_missions';

    protected $fillable = [
        'id_number',
        'name_khmer',
        'name_latin',
        'account_number',
    ];
}
