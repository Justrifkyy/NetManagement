<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $installation_id
 * @property int $lead_id
 * @property int|null $technician_id
 * @property bool $internet_active_confirmation
 * @property \Carbon\Carbon|null $handover_date
 * @property string|null $final_technician_notes
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class HandoverConfirmation extends Model
{
    use HasFactory;

    protected $fillable = [
        'installation_id',
        'lead_id',
        'technician_id',
        'internet_active_confirmation',
        'handover_date',
        'final_technician_notes',
    ];

    protected $casts = [
        'handover_date' => 'date',
        'internet_active_confirmation' => 'boolean',
    ];

    public function installation()
    {
        return $this->belongsTo(InstallationForm::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
