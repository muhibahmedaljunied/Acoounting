<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = ['id','name'];

    public function daily()
    {
        return $this->morphMany(GroupAccount::class, 'dailyable');
    }
    

}
