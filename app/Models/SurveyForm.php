<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $lead_id
 * @property int|null $technician_id
 * @property string|null $survey_status
 * @property \Carbon\Carbon|null $survey_date
 * @property string|null $survey_result
 * @property string|null $location_challenge
 * @property string|null $location_photo_path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class SurveyForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'technician_id',
        'survey_status',
        'survey_date',
        'survey_result',
        'location_challenge',
        'location_photo_path',
    ];

    protected $casts = [
        'survey_date' => 'date',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
