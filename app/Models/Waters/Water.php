<?php

namespace App\Models\Waters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Water extends Model
{
    use HasFactory;

    protected $table = 'waters';

    protected $fillable = [
        'usage_unit_water',       // អង្គភាពប្រើប្រាស់
        'location_number_water',  // លេខសំគាល់
        'invoice_number',         // លេខវិក្កយបត្រ
        'usage_date',             // កាលបរិច្ឆេទ
        'usage_start',            // កាលបរិច្ឆេទចាប់ផ្ដើមប្រើប្រាស់
        'usage_end',              // កាលបរិច្ឆេទចប់ប្រើប្រាស់
        'kilowatt_water',         // បរិមាណប្រើប្រាស់
        'total_cost',             // ថ្លៃប្រើប្រាស់
    ];

    public function titleUsageUnitWater()
    {
        return $this->belongsTo(TitleUsageUnitWater::class, 'usage_unit_water', 'title_usage_unit_water');
    }
}
