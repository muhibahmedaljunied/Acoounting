<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AllowanceType extends Model
{
    protected $fillable = ['name'];

    public function allowance()
    {
        return $this->hasMany(Allowance::class);
    }
}
