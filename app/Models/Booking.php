<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'production_id',
        'total_amount',
        'status',
        'notes',
        'payment_proof_url',
    ];

}

