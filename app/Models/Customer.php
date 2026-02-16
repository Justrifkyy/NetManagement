<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'user_id',
        'lead_id',
        'customer_code',
        'nik',
        'phone_number',
        'address_installation',
        'coordinates',
        
        // Data Teknis (Diisi Admin/Teknisi)
        'pppoe_username',
        'pppoe_password',
        'is_isolated',
    ];

    protected $casts = [
        'is_isolated' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}