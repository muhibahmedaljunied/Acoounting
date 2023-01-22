<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenceType extends Model
{
    protected $fillable = ['id','name'];

    public function expence()
    {
        return $this->hasMany(Expence::class);
    }

}
