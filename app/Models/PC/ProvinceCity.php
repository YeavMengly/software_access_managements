<?php

namespace App\Models\PC;

use App\Models\Electrics\TitleUsageUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvinceCity extends Model
{
    use HasFactory;

    protected $table  = 'province_cities';
    protected $fillable  = [
        'province_city'
    ];

    public function titleUsageUnit(){
        return $this->hasMany(TitleUsageUnit::class, 'province_city', 'province_city');
    }
}
