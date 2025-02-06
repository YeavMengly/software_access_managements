<?php
namespace App\Models\Result;

use App\Models\Mission\MissionTag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CambodiaMission extends Model
{
    use HasFactory;
    protected $table = 'cam_missions';
    protected $fillable = [
        'name',
        'role',
        'position_type',
        'letter_number',
        'letter_format',
        'letter_date',
        'pocket_money',
        'meal_money',
        'mission_objective',
        'location',
        'mission_start_date',
        'mission_end_date',
        'days_count',
        'nights_count',
        'pocket_money', 
        'meal_money', 
        'accommodation_money', 
        'total_pocket_money', 
        'total_meal_money', 
        'total_accommodation_money',
        'travel_allowance',
        'other_allowances',
        'final_total',
        'm_tag',
        'p_format'
    ];
    
    public function missionTag(){
        return $this->belongsTo(MissionTag::class, 'm_tag');
    }
}
