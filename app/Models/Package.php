<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name', 
        'price', 
        'speed_mbps', 
        'installation_fee', // Biaya pasang default
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'installation_fee' => 'decimal:2',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // Relasi: Satu paket bisa dipilih oleh banyak Prospek (Lead)
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}