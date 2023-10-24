<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ExtraDetail extends Model
{
    protected $fillable = ['extra_id','extra_sanction_id','date'];
    // protected $table = 'admin';

    public function extra()
    {
        return $this->belongsTo(Extra::class);
    }


    public function extra_sanction()
    {
        return $this->belongsTo(ExtraSanction::class);
    }



}
