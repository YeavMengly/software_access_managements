<?php

namespace App\Models;

use App\Models\Code\Report;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanMandate extends Model
{
    use HasFactory;

    protected $table = 'loan_mandates';

    protected $fillable = [
        'sub_account_key',
        'report_key',
        'internal_increase',
        'unexpected_increase',
        'additional_increase',
        'total_increase',
        'decrease',
        'editorial',
    ];

    public function reports(){
        return $this->belongsTo(Report::class, 'report_key');
    }
}
