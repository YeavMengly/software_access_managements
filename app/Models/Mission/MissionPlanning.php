<?php

namespace App\Models\Mission;

use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionPlanning extends Model
{
    use HasFactory;

    protected $table = 'mission_plannings';

    protected $fillable = [
        'sub_account_key',
        'report_key',
        'pay_mission',
        'mission_type'
    ];

    // belong table to report class
    public function report()
    {
        return $this->belongsTo(Report::class, 'report_key',);
    }

    public function subAccountKey()
    {
        return $this->belongsTo(SubAccountKey::class, 'sub_account_key'); // Adjust 'id' if needed.
    }
    
    public function missionType(){
        return $this->belongsTo(MissionType::class, 'mission_type');
    }
}
