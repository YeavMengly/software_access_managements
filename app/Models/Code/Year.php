<?php

namespace App\Models\Code;

use App\Models\DataMandate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;

    protected $table = 'years';
    protected $fillable = [
        'date_year'
    ];

    protected $casts = [
        'date_year' => 'date:Y-m-d', // Ensure proper date format
    ];
    public function report()
    {
        return $this->hasMany(Report::class, 'date_year', 'id'); // Reference reports by year_id
    }
    
    public function dataMandate()
    {
        return $this->hasMany(DataMandate::class, 'date_year', 'id'); // Reference reports by year_id
    }
    
}
