<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function machines()
    {
        return $this->hasMany(Machine::class);
    }
}
