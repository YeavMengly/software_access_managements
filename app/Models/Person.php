<?php

namespace App\Models;

use App\Models\Result\ResultMission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'position_type',
    ];

    public function mission()
    {
        return $this->belongsTo(ResultMission::class);
    }
}
