<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $installation_id
 * @property int $lead_id
 * @property string|null $device_type
 * @property string|null $device_brand
 * @property string|null $serial_number
 * @property string|null $mac_address
 * @property string $device_condition
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class DeviceConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'installation_id',
        'lead_id',
        'device_type',
        'device_brand',
        'serial_number',
        'mac_address',
        'device_condition',
    ];

    public function installation()
    {
        return $this->belongsTo(InstallationForm::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
