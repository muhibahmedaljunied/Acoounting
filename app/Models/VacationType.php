<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VacationType extends Model
{
    public function vacation()
    {
        return $this->hasMany(Vacation::class);
    }
}
