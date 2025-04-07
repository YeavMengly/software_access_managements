<?php

namespace App\Models\Electrics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Electric extends Model
{
    use HasFactory;

    protected $table = 'electrics';

    protected $fillable = [
        'usage_unit',       // អង្គភាពប្រើប្រាស់
        'location_number',  // លេខទីតាំង
        'usage_date',       // កាលបរិច្ឆេទ
        'usage_start',
        'usage_end',
        'kilowatt_energy',  // ថាមពលគីឡូវ៉ាត់
        'reactive_energy',  // ថាមពលរ៉េអាក់ទិក
        'total_amount',     // ប្រាក់សរុបជារៀល
    ];

    public function titleUsageUnit()
    {
        return $this->belongsTo(TitleUsageUnit::class, 'usage_unit', 'title_usage_unit');
    }
}
