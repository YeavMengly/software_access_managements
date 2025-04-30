<?php

namespace App\Models\Supplies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class Supplie extends Model
{
    use HasFactory;

    protected $table = 'supplies';

    protected $fillable = [
        'supplie_id',     // សម្ភារៈ
        'date',           //កាលបរិច្ឆេទ
        'receipt_number', //លេខបណ្ណ
        'description',    // បរិយាយ
        'unit',           // ឯកតា
        'quantity',       // ចំនួន
        'quantity_used',  // ចំនួនបានប្រើ
        'remain_supplie'  // ចំនួននៅសល់
    ];


    public function totalSupplie()
    {
        return $this->hasMany(TotalSupplie::class, 'release_date', 'supplie_id');
    }
}
