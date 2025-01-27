<?php

namespace App\Models\Mission;

use App\Models\Result\CambodiaMission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionTag extends Model
{
    use HasFactory;

    protected $table = 'mission_tags';
    protected $fillable = ['m_tag'];
    
    public function cambodiaMission(){
        return $this->hasMany(CambodiaMission::class, 'm_tag'); 
    }
}