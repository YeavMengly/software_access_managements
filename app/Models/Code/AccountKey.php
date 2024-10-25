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

    // Define relationship with Key model
    public function key()
    {
        return $this->belongsTo(Key::class, 'code', 'code'); // Ensure 'code' is used for both keys
    }

    // Define relationship with SubAccountKey model
    public function subAccountKey()
    {
        return $this->hasMany(SubAccountKey::class, 'account_key');
    }

    // Define relationship with CertificateData model
    public function certificateData()
    {
        return $this->hasMany(CertificateData::class, 'account_key');
    }
}
