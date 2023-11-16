<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    protected $fillable = [
        'id','account_id','name','email','phone','address','status'
    ];
}
