<?php

namespace App\Models\Fuels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelTag extends Model
{
    use HasFactory;

    protected $table = 'fuel_tags';

    protected $fillable = [
        'fuel_tag'
    ];

    public function fuelTotal()
    {
        return $this->hasOne(FuelTotal::class, 'product_name', 'fuel_tag');
    }


    public function fuel()
    {
        return $this->hasOne(Fuel::class, 'oil_type', 'fuel_tag');
    }
}
