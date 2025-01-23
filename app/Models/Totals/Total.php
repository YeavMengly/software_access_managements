<?php

namespace App\Models\Totals;

use App\Models\Code\Key;
use App\Models\Code\Report;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Total extends Model
{
    use HasFactory;

    protected $table = 'totals';
    protected $fillable = [
        'code',
        'fin_law',
        'new_loan',
        'cost_early_balance',
        'cost_apply',
        'cost_average',
        'cost_sum_ref',
        'cost_average',
        'cost_remain',
        'req_mandate_early_balance',
        'req_mandate_apply',
        'req_mandate_average',
        'req_mandate_sum_ref',
        'req_mandate_average',
        'req_mandate_remain',
        'millions_riel',

    ];

    // belong table to report class
    public function report()
    {
        return $this->belongsTo(Report::class, 'fin_law');
    }

    // belong table to key class
    public function key()
    {
        return $this->belongsTo(Key::class, 'code');
    }
}
