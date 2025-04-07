<?php

namespace App\Models\Waters;

use App\Models\PC\ProvinceCity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitleUsageUnitWater extends Model
{
    use HasFactory;

    protected $table = 'title_usage_unit_waters';

    protected $fillable = [
        'title_usage_unit_water',
        'location_number_water', // Ensure this field exists
        'province_city' // New field added
    ];

    // public function water()
    // {
    //     return $this->hasOne(Water::class,'usage_unit_water' , 'title_usage_unit_water');
    // }

    public function waters()
    {
        return $this->hasMany(Water::class, 'usage_unit_water', 'title_usage_unit_water');
    }

    public function provinceCity()
    {
        // Updated relationship to match the column name directly
        return $this->belongsTo(ProvinceCity::class, 'province_city', 'province_city');
    }
}
