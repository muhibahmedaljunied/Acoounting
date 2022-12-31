<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Delay extends Model
{
    protected $fillable = ['staff_id','delay_type_id','date'];
}
