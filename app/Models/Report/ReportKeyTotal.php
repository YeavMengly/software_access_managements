<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportKeyTotal extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_key_prefix',
        'fin_law',
        'current_loan',
        'decrease',
        'new_credit_status',
        'early_balance',
        'apply',
        'total_increase',
        'total_sum_refer',
        'total_remain',
    ];
}
