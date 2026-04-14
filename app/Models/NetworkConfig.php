<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $installation_id
 * @property int $lead_id
 * @property string|null $router_area
 * @property string|null $port_interface
 * @property string|null $vlan_id
 * @property string|null $olt_access_point
 * @property string $connection_mode
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class NetworkConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'installation_id',
        'lead_id',
        'router_area',
        'port_interface',
        'vlan_id',
        'olt_access_point',
        'connection_mode',
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
