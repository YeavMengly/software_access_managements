<?php

namespace App\Models\Certificates;

use App\Models\Code\Report;
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

}
