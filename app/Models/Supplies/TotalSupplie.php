<?php

namespace App\Models\Supplies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalSupplie extends Model
{
    use HasFactory;

    protected $table = 'total_supplies';

    protected $fillable = [
        'company_name', // អតិថិជន
        'release_date', // កាលបរិច្ឆេទចេញផ្សាយ
        'refers',       // យោង
        'description',  // ពណ៍នា
        'warehouse',   // ឃ្លាំង
        'product_name',        // រាយមុខទំនិញ
        'unit',
        'quantity',         // បរិមាណ
        'unit_price',       // តម្លៃឯកតា
        'total_price',      // តម្លៃសរុប
        'source',           // ប្រភព
        'production_year'   // ឆ្នាំផលិត
    ];

    public function supplie(){
        return $this->belongsTo(Supplie::class, 'supplie_id', 'release_date');
    }
}
