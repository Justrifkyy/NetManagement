<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $installation_id
 * @property int $lead_id
 * @property string|null $connection_status
 * @property float|null $speed_test_download
 * @property float|null $speed_test_upload
 * @property int|null $latency
 * @property string|null $test_result_photo_path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ConnectionTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'installation_id',
        'lead_id',
        'connection_status',
        'speed_test_download',
        'speed_test_upload',
        'latency',
        'test_result_photo_path',
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
