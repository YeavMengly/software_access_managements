<?php

namespace App\Models\Electrics;

use App\Models\PC\ProvinceCity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitleUsageUnit extends Model
{
    use HasFactory;

    protected $table = 'title_usage_units';

    protected $fillable = [
        'title_usage_unit',
        'location_number',
        'province_city' // New field added
    ];

    public function electric()
    {
        return $this->hasOne(Electric::class,'usage_unit' , 'title_usage_units');
    }
    

    public function provinceCity() {
        // Updated relationship to match the column name directly
        return $this->belongsTo(ProvinceCity::class, 'province_city', 'province_city');
    }
    
}
