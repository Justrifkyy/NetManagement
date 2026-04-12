<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property string|null $email
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class MasterMarketing extends Model
{
    protected $table = 'master_marketings';

    protected $fillable = [
        'name',
        'code',
        'phone',
    ];
}
