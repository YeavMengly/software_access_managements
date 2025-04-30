<?php

namespace App\Models\Fuels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    use HasFactory;

    protected $fillable = [
        'fuel_id',
        'date',
        'receipt_number',
        'description',
        'oil_type',
        'quantity',
        'quantity_used',
        'total'
    ];

    // public function fuelTotal()
    // {
    //     return $this->belongsTo(FuelTotal::class, 'fuel_id', 'warehouse_entry_number');
    // }
    public function fuelTotal()
    {
        return $this->hasOne(FuelTotal::class, 'warehouse_entry_number', 'fuel_id');
    }


    public function getOilTypeWithQuantity()
    {
        $paired = [];
        foreach ($this->oil_type as $index => $oilType) {
            $paired[] = [
                'oil_type' => $oilType,
                'quantity_used' => $this->quantity_used[$index] ?? null,
            ];
        }
        return $paired;
    }
}
