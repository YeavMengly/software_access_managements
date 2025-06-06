<?php

namespace App\Models\Result;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbroadMission extends Model
{
    use HasFactory;
    protected $table = 'abroad_missions';
    protected $fillable = [
        'name',
        'role',
        'position_type',
        'letter_number',
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
    ];
}
