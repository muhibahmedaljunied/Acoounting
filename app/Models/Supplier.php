<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'id','account_id','name', 'last_name','email','phone','address','status'
    ];
}
