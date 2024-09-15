<?php

namespace App\Models\Loans;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SummaryReport extends Model
{
    use HasFactory;

    // Table name if not following Laravel's naming convention
    protected $table = 'summary_reports';

    // The attributes that are mass assignable
    protected $fillable = [
        'program',
        'fin_law',
        'current_loan',
        'total_increase',
        'decrease',
        'new_credit_status',
        'total_early_balance',
        'avg_total_early_balance',
        'total_apply',
        'avg_total_apply',
        'total_sum_refer',
        'avg_total_sum_refer',
        'total_remain',
        'avg_total_remain',
    ];

    // The attributes that should be cast to native types
    protected $casts = [
        'fin_law' => 'decimal:2',
        'current_loan' => 'decimal:2',
        'total_increase' => 'decimal:2',
        'decrease' => 'decimal:2',
        'new_credit_status' => 'decimal:2',
        'total_early_balance' => 'decimal:2',
        'avg_total_early_balance' => 'decimal:2',
        'total_apply' => 'decimal:2',
        'avg_total_apply' => 'decimal:2',
        'total_sum_refer' => 'decimal:2',
        'avg_total_sum_refer' => 'decimal:2',
        'total_remain' => 'decimal:2',
        'avg_total_remain' => 'decimal:2',
    ];
}
