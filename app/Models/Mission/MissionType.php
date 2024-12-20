<?php

namespace App\Models\Mission;

use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionType extends Model
{
    use HasFactory;

    protected $table = 'mission_types';
    protected $fillable = ['mission_type'];

    public function missionPlanning(){
        return $this->hasMany(MissionPlanning::class, 'mission_type');
    }

}
