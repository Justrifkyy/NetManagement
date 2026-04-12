<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemIntegration extends Model
{
    protected $table = 'system_integrations';

    protected $fillable = [
        'service_name',
        'api_key',
        'api_secret',
        'webhook_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
