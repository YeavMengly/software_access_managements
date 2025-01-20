<?php

namespace App\Models\Code;

use App\Models\Certificates\CertificateData;
use App\Models\DataMandate;
use App\Models\Mandates\Mandate;
use App\Models\Mission\MissionPlanning;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAccountKey extends Model
{
    use HasFactory;

    protected $table = 'sub_account_keys';

    protected $fillable = [
        'account_key',
        'sub_account_key',
        'name_sub_account_key'

    ];

    // belong table to key class
    public function key()
    {
        return $this->belongsTo(Key::class, 'code',  'code');
    }

    // belong table to accountKey class
    public function accountKey()
    {
        return $this->belongsTo(AccountKey::class, 'account_key',  'account_key');
    }

    // point to report class
    public function report()
    {
        return $this->hasMany(Report::class, 'sub_account_key', 'sub_account_key');
    }

    public function certificateData()
    {
        return $this->hasMany(CertificateData::class, 'sub_account_key');
    }

    public function loans(){
        return $this->hasMany(Loans::class, 'sub_account_key', 'sub_account_key');
    }

    public function missionPlanning(){
        return $this->hasMany(MissionPlanning::class, 'sub_account_key');
    }

    public function mandate(){
        return $this->hasOne(Mandate::class, 'sub_account_key', 'sub_account_key');
    }

    public function dataMandates(){
        return $this->hasMany(DataMandate::class, 'sub_account_key');
    }

}
