<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ExtraType extends Model
{
    protected $fillable = ['name'];

    public function extra()
    {
        return $this->hasMany(Extra::class);
    }

}
