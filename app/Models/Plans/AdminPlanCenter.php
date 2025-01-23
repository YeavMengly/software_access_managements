<?php

namespace App\Models\Plans;

use App\Models\Code\Key;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPlanCenter extends Model
{
    use HasFactory;

    protected $table = 'admin_plan_centers';
    protected $fillable = [
        'code',
        'accord_content',
        'fin_law',
        'total',
        'total_april',
        'total_may',
        'total_june',
        'sth'
    ];

    public function key(){
        return $this->belongsTo(Key::class, 'code');
    }
}
