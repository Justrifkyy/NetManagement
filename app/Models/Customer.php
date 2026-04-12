<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int|null $lead_id
 * @property string $customer_code
 * @property string|null $nik
 * @property string|null $phone_number
 * @property string|null $address_installation
 * @property string|null $coordinates
 * @property string|null $pppoe_username
 * @property string|null $pppoe_password
 * @property bool $is_isolated
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method bool update(array $attributes = [])
 */
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