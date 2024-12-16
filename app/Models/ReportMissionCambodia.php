<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportMissionCambodia extends Model
{
    use HasFactory;

    protected $table = 'imported_data';
    
    protected $fillable = [
        'id_number', 
        'name_khmer', 
        'name_latin', 
        'account_number', 
        'total_amount',
    ];
}