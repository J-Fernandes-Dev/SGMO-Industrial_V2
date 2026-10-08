<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable = [
        'section_id',
        'code',
        'brand',
        'model',
        'serial_number',
        'status',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function components()
    {
        return $this->hasMany(Component::class);
    }
}
