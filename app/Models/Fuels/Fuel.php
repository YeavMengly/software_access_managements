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
        // 'fuel_total_id',
        'oil_type',
        'quantity',
        'quantity_used',
    ];

    protected $casts = [
        'fuel_date' => 'date',
        'oil_type' => 'array',
        'quantity' => 'array',
        'quantity_used' => 'array',
    ];

    public function fuelTotal()
    {
        return $this->belongsTo(FuelTotal::class, 'fuel_id', 'id');
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
