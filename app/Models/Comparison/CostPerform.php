<?php

namespace App\Models\Comparison;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostPerform extends Model
{
    use HasFactory;

    protected $table = 'cost_performs';
    protected $fillable = [
        'code_id',
        'fin_law_id',
        'new_loan',
        'pay_in',
        'perform_in',
        'compare_avg_one',
        'guarenty',
        'compare_avg_two'
    ];

}
