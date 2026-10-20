<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function component()
    {
        return $this->belongsTo(Component::class);
    }



}
