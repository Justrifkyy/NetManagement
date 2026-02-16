<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NetworkAsset extends Model
{
    protected $fillable = [
        'name', 
        'location', 
        'ip_address', 
        'brand', 
        'type', // OLT, Router, AP, ODP
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'router_id');
    }
}