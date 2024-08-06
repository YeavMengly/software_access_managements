<?php

namespace App\Models\Code;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountKey extends Model
{
    use HasFactory;
    
    protected $table = 'account_keys';
    protected $fillable = [
        'code_id',
        'account_key',
        'name_account_key'
    ];
    

    // AccountKey.php
    public function key()
    {
        return $this->belongsTo(Key::class, 'code_id');
    }
    


    public function subAccountKey()
    {
        return $this->hasMany(SubAccountKey::class, 'account_key_id');
    }
}
