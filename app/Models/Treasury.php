<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treasury extends Model
{
    protected $fillable = ['id','name'];

    
    public function daily()
    {
        return $this->morphMany(GroupAccount::class, 'dailyable');
    }

}
