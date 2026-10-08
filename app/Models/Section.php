<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'code',
        'name',
    ];

    public function machines()
    {
        return $this->hasMany(Machine::class);
    }
}
