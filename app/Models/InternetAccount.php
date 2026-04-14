<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $lead_id
 * @property int|null $installation_id
 * @property string|null $pppoe_username
 * @property string|null $pppoe_password
 * @property string|null $service_package
 * @property string $initial_service_status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class InternetAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'installation_id',
        'pppoe_username',
        'pppoe_password',
        'service_package',
        'initial_service_status',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function installation()
    {
        return $this->belongsTo(InstallationForm::class);
    }
}
