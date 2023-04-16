<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ExtraSanction extends Model
{
    protected $fillable = ['staff_id','extra_type_id','start_time','end_time'];

    public function extra()
    {
        return $this->hasMany(Extra::class);
    }


  

}
