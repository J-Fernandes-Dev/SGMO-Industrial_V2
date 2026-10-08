<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrders extends Model
{
    protected $fillable = [
        'machine_id',
        'user_id',
        'assigned_to',
        'component_id',
        'type',
        'priority',
        'status',
        'description',
        'technical_report',
        'downtime_hours',
        'started_at',
        'completed_at',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
