<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupAccount extends Model
{
    // protected $fillable = ['id','name','group_type_id','account_id'];

    public function dailyable()
    {
        return $this->morphTo();
    }

}
