<?php

namespace App\Models\Code;

use App\Models\Certificates\Certificate;
use App\Models\Certificates\CertificateData;
use App\Models\DataMandate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loans extends Model
{
    use HasFactory;

    protected $table = 'loans';
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

    public function subAccountKey()
    {
        return $this->belongsTo(SubAccountKey::class, 'sub_account_key', 'sub_account_key');
    }

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_key', 'id');
    }

    public function certificatData(){
        return $this->hasMany(CertificateData::class, 'report_key');
    }

    public function certificate(){
        return $this->hasOne(Certificate::class, 'early_balance');
    }
}