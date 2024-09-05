<?php

namespace App\Models\Certificates;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmountCertificate extends Model
{
    use HasFactory;

    protected $table = 'amount_certificates';
    protected $fillable = [
        'amount'
    ];
}
