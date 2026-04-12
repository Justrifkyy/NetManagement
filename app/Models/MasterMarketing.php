<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterMarketing extends Model
{
    protected $table = 'master_marketings';

    protected $fillable = [
        'name',
        'code',
        'phone',
    ];
}
