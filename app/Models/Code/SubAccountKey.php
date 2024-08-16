<?php

namespace App\Models\Code;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAccountKey extends Model
{
    use HasFactory;

    protected $table = 'sub_account_keys';

    protected $fillable = [
        'account_key_id',
        'sub_account_key',
        'name_sub_account_key'

    ];

    public function key()
    {
        return $this->belongsTo(Key::class, 'code_id');
    }

    public function accountKey()
    {
        return $this->belongsTo(AccountKey::class, 'account_key_id');
    }
    


    public function report()
    {
        return $this->hasMany(Report::class, 'sub_account_key_id');
    }
}
