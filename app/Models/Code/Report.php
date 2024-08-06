<?php

namespace App\Models\Code;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';
    protected $fillable = [
        // 'sub_account_key_id',
        // 'report_key',
        // 'name_report_key',
        // 'fin_law',
        // 'current_loan',
        // 'internal_increase',
        // 'unexpected_increase',
        // 'additional_increase',
        // 'decrease',
        'sub_account_key_id',
        'report_key',
        'name_report_key',
        'fin_law',
        'current_loan',
        'internal_increase',
        'unexpected_increase',
        'additional_increase',
        'total_increase',
        'decrease',
        'editorial',
        'new_credit_status',
        'early_balance',
        'apply',
        'deadline_balance',
        'credit',
        'law_average',
        'law_correction'
    ];

    public function subAccountKey()
    {
        return $this->belongsTo(SubAccountKey::class, 'sub_account_key_id');
    }
}
