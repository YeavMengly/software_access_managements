<?php

namespace App\Models\Code;

use App\Models\Certificates\CertificateData;
use App\Models\Totals\Total;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';
    protected $fillable = [
        'sub_account_key',
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
        'law_correction',
    ];

    protected $dates = ['date_column'];


    // belong table to subAccount class
    public function subAccountKey()
    {
        return $this->belongsTo(SubAccountKey::class, 'sub_account_key');
    }

    // Point to total class
    public function total()
    {
        return $this->hasMany(Total::class, 'fin_law');
    }

    // Point to certificateData Class


    public function certificateData()
    {
        return $this->hasMany(CertificateData::class, 'report_key');
    }
}
