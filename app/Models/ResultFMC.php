<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultFMC extends Model
{
    use HasFactory;

    protected $table = 'result_f_m_c_s';

    protected $fillable = [
        'sub_account_key',
        'report_key',
        'fin_law',
        'v_mandate',
        'v_certificate'
    ];
}
