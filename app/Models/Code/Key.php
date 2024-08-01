<?php

namespace App\Models\Code;

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

    public function accountKey()
    {
        return $this->hasMany(AccountKey::class, 'code_id');
    }
}

