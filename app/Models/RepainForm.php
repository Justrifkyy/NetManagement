<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairForm extends Model
{
    use HasFactory;

    protected $table = 'repair_forms';

    protected $fillable = [
        'customer_id',
        'repair_date',
        'issue_description',
        'resolution_notes',
        'is_resolved',
    ];

    protected $casts = [
        'repair_date' => 'date',
        'is_resolved' => 'boolean',
    ];

    // Relasi balik ke data pelanggan yang mengalami gangguan
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi polimorfik ke model Ticket (Task Manager)
    public function ticket()
    {
        return $this->morphOne(Ticket::class, 'ticketable');
    }
}