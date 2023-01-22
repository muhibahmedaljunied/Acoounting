<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expence extends Model
{
    protected $fillable = ['id','expence_type_id','qty','note','date'];

    public function expence_type()
    {
        return $this->belongsTo(ExpenceType::class);
    }

}
