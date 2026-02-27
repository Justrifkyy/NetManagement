<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketing_id',
        'name',
        'mother_name',
        'phone',
        'email',
        'customer_type',
        'business_name',
        'emergency_name',
        'emergency_phone',
        'emergency_relation',
        'address_ktp',
        'address_installation',
        'rt_rw',
        'village',
        'district',
        'city',
        'province',
        'postal_code',
        'landmark',
        'coordinates',
        'package_id',
        'promo_code',
        'status',
        'source',
        'survey_date',
        'installation_date',
        'preferred_time',
        'notes_summary',
        'notes_obstacle',
        'notes_special',
        'ktp_image_path',
        'house_image_path',
        'customer_image_path',
    ];

    protected $casts = [
        'survey_date' => 'date',
        'installation_date' => 'date',
    ];

    // Relasi ke Paket Internet
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // Relasi ke User Marketing
    public function marketing()
    {
        return $this->belongsTo(User::class, 'marketing_id');
    }

    // Relasi: Prospek (Lead) yang sudah diconvert memiliki satu data Customer
    public function customerProfile()
    {
        return $this->hasOne(Customer::class, 'lead_id');
    }
}
