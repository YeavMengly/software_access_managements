<?php

namespace App\Models\Code;

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
    public function reports()
    {
        return $this->hasMany(Report::class, 'date_year', ); // Reference reports by year_id
    }
    
}
