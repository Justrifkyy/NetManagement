<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $customer_id
 * @property int|null $package_id
 * @property string|null $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Subscription extends Model
{
    protected $fillable = [
        'customer_id',
        'package_id',
        'pppoe_username',
        'pppoe_password',
        'ip_address',
        'installation_date',
        'billing_due_date',
        'status',
    ];

    protected $casts = [
        'installation_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // Satu langganan punya banyak tagihan (bulan ini, bulan lalu, dst)
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}