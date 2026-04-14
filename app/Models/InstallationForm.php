<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $lead_id
 * @property int|null $technician_id
 * @property \Carbon\Carbon|null $installation_date
 * @property string|null $connection_type
 * @property int|null $cable_length
 * @property string|null $device_placement
 * @property string|null $installation_status
 * @property string|null $installation_notes
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class InstallationForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'technician_id',
        'installation_date',
        'connection_type',
        'cable_length',
        'device_placement',
        'installation_status',
        'installation_notes',
    ];

    protected $casts = [
        'installation_date' => 'date',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function deviceConfig()
    {
        return $this->hasOne(DeviceConfig::class);
    }

    public function networkConfig()
    {
        return $this->hasOne(NetworkConfig::class);
    }

    public function connectionTest()
    {
        return $this->hasOne(ConnectionTest::class);
    }

    public function handoverConfirmation()
    {
        return $this->hasOne(HandoverConfirmation::class);
    }
}
