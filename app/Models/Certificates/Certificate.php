<?php

namespace App\Models\Certificates;;

use App\Models\Code\Report;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $table = 'certificates';
    protected $fillable = [
        'report_key',
        'early_balance'
    ];


    // Point to certificateData class
    public function certificateData()
    {
        return $this->hasMany(Report::class, 'early_balance');
    }

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_key');
    }
    
}
