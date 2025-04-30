<?php

namespace App\Models\Fuels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelTotal extends Model
{
    use HasFactory;

    protected $table = 'fuel_totals';

    // Fillable properties for the model
    protected $fillable = [
        'company_name', // អតិថិជន
        'release_date', // កាលបរិច្ឆេទចេញផ្សាយ
        'refers',       // យោង
        'description',  // ពណ៍នា
        'warehouse_entry_number',   // លេខបញ្ចូលឃ្លាំង
        'warehouse',                // សារពើភ័ណ្ឌ
        'product_name', // ឈ្មោះផលិតផល
        'quantity', // បរិមាណ
        'unit_price', // តម្លៃត្រង
        'fuel_total' // សរុបប្រេង
    ];

    // FuelTotal Model
    public function fuels()
    {
        return $this->hasMany(Fuel::class, 'fuel_id', 'warehouse_entry_number'); // Assuming 'fuel_id' exists in Fuel model
    }

    public function fuelTag()
    {
        return $this->belongsTo(FuelTag::class, 'product_name', 'fuel_tag');
    }
}
