<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string|null $marketing_code
 * @property bool $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method bool save()
 * @method bool update(array $attributes = [])
 * @method static create(array $attributes = [])
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',             // Role: super_admin, admin, marketing, technician, customer
        'marketing_code',   // Kode Sales (Unik)
        'is_active',        // Status Aktif/Nonaktif
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // Relasi: User (Marketing) memiliki banyak Leads
    public function leads()
    {
        return $this->hasMany(Lead::class, 'marketing_id');
    }

    // Relasi: User (Teknisi) memiliki banyak Tiket
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'technician_id');
    }

    // Relasi: User (Customer) memiliki satu profil Customer
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
}