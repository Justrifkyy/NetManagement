<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterTechnician extends Model
{
    protected $table = 'master_technicians';

    protected $fillable = [
        'name',
        'phone',
        'area_id',
    ];

    public function area()
    {
        return $this->belongsTo(MasterArea::class);
    }
}
