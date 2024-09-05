<?php

namespace App\Models\Certificates;;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $table = 'certificates';
    protected $fillable = [
        'name_certificate'
    ];


    // Point to certificateData class
    public function certificateData()
    {
        return $this->hasMany(CertificateData::class, 'name_certificate');
    }
}
