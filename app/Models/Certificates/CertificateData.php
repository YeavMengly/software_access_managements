<?php

namespace App\Models\Certificates;

use App\Models\Code\AccountKey;
use App\Models\Code\Key;
use App\Models\Code\Loans;
use App\Models\Code\Report;
use App\Models\Code\SubAccountKey;
use Illuminate\Database\Eloquent\Model;

class CertificateData extends Model
{
    protected $table = 'certificate_data';
    protected $fillable = [
        'report_key',
        'name_certificate',
        'value_certificate',
        'amount'
    ];

    // belong table to certificate class
    public function certificate()
    {
        return $this->belongsTo(Certificate::class, 'name_certificate');
    }

    // belong table to report class
    public function report()
    {
        return $this->belongsTo(Report::class, 'report_key');
    }

    public function accountKey(){
        return $this->belongsTo(AccountKey::class, 'account_key');
        
    }

    public function subAccountKey(){
        return $this->belongsTo(SubAccountKey::class, 'sub_account_key');
    }

    public function key(){
        return $this->belongsTo(Key::class, 'code');
    }

    public function loans(){
        return $this->belongsTo(Loans::class, 'report_key');
    }

}
