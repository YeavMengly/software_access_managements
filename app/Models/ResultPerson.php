<?php

namespace App\Models;

use App\Models\Result\ResultMission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'position_type',
        'mission_id'
    ];

    public function mission()
    {
        return $this->belongsTo(ResultMission::class);
    }
}
