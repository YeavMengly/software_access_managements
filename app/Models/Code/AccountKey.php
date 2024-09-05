<?php

namespace App\Models\Code;

use App\Models\Certificates\CertificateData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountKey extends Model
{
    use HasFactory;

    protected $table = 'account_keys';
    protected $fillable = [
        'code',
        'account_key',
        'name_account_key'
    ];

    // belong table to key class
    public function key()
    {
        return $this->belongsTo(Key::class, 'code', );
    }

    // Point to subAccount class
    public function subAccountKey()
    {
        return $this->hasMany(SubAccountKey::class, 'account_key');
    }

    public function certificateData()
    {
        return $this->hasMany(CertificateData::class, 'account_key');
    }
}
