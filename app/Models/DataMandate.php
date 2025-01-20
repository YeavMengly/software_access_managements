<?php

namespace App\Models;

use App\Models\Code\Loans;
use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use App\Models\Code\Year;
use App\Models\Mandates\Mandate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMandate extends Model
{
    use HasFactory;

    protected $table = 'data_mandates';
    protected $fillable = [
        'sub_account_key',
        'report_key',
        'name_report_key',
        'fin_law',
        'current_loan',
        'date_year',
        'new_credit_status',
        'early_balance',
        'apply',
        'deadline_balance',
        'credit',
        'law_average',
        'law_correction',
    ];

    protected $casts = [
        'date_year' => 'date:Y-m-d', // Ensure proper date format
    ];
    protected $dates = ['date_column'];

    public function year()
    {
        return $this->belongsTo(Year::class, 'date_year', 'id');
    }
    public function subAccountKey()
    {
        return $this->belongsTo(SubAccountKey::class, 'sub_account_key', 'sub_account_key'); // Ensure 'sub_account_key_id' matches your database column
    }

    public function mandates()
    {
        return $this->hasOne(Mandate::class, 'report_key', 'report_key');
    }

    public function reports()
    {
        return $this->belongsTo(Report::class, 'report_key', 'report_key');
    }
}
