<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property string|null $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class MasterArea extends Model
{
    protected $table = 'master_areas';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];
}
