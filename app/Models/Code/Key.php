<?php

namespace App\Models\Code;

use App\Models\Certificates\CertificateData;
use App\Models\Totals\Total;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    use HasFactory;

    protected $table = 'keys';
    protected $fillable = [
        'code',
        'name'
    ];

    // Point to accountKey class
    public function accountKey()
    {
        return $this->hasMany(AccountKey::class, 'code',);
    }

    public function certificateData()
    {
        return $this->hasMany(CertificateData::class, 'code');
    }

    public function totals(){
        return $this->hasMany(Total::class, 'code');
    }
}

