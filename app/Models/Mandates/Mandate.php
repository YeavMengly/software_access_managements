<?php

namespace App\Models\Mandates;

use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use App\Models\DataMandate;
use App\Models\Mission\MissionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mandate extends Model
{
    use HasFactory;

    protected $table = 'mandates';
    protected $fillable = [
        'sub_account_key',
        'report_key',
        'value_mandate',
        'mission_type',
        'attachments',
        'date_mandate'
    ];


    public function subAccountKey(){
        return $this->belongsTo(SubAccountKey::class, 'sub_account_key', 'sub_account_key');
    }

    // belong table to report class
    public function dataMandates()
    {
        return $this->belongsTo(DataMandate::class, 'report_key', 'report_key');
    }

    public function missionType(){
        return $this->belongsTo(MissionType::class, 'mission_type');
    }
}
