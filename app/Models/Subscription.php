<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_id',
        'start_date',
        'end_date',
        'status',
        'payment_proof_url',
    ];

    // ✅ Link subscription → production
    public function production()
    {
        return $this->belongsTo(Production::class);
    }
}
