<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
    'name',
    'slug',
    'contact_email',
    'whatsapp',
    'subscription_end',
    'active',
    ];


    // ✅ Link production → subscription
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
}
