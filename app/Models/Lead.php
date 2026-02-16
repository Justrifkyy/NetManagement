<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketing_id', 
        
        // A. Identitas
        'name', 
        'phone', 
        'email', 
        'customer_type', 
        'business_name',
        
        // B. Kontak Darurat (BARU)
        'emergency_name',
        'emergency_phone',
        'emergency_relation',

        // C. Alamat Lengkap
        'address', 
        'rt_rw', 
        'village', 
        'district', 
        'city', 
        'province', 
        'postal_code', 
        'landmark', 
        'coordinates',
        
        // D. Paket
        'package_id', 
        'promo_code',
        
        // E. Status & Sumber
        'status', 
        'source', 
        
        // F. Penjadwalan
        'survey_date', 
        'installation_date', 
        'preferred_time',
        
        // G. Catatan
        'notes_summary', 
        'notes_obstacle', 
        'notes_special',
        
        // H. Foto Dokumen
        'ktp_image_path', 
        'house_image_path', 
        'customer_image_path'
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
}