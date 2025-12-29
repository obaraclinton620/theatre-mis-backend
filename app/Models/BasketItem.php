<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasketItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_id',
        'user_id',
        'performance_id',
        'audience_count',
        'price_per_audience', 
        'price',
    ];
    }
