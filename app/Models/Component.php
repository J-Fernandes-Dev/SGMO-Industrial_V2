<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $fillable = [
        'machine_id',
        'name',
        'part_number',
        'category',
        'status',
        'notes',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
