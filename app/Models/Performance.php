<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_id',
        'title',
        'category',
        'description',
        'price_per_audience',
        'duration_minutes',
        'poster_url',
        'active',
    ];
}
