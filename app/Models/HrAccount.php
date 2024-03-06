<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrAccount extends Model
{
    protected $fillable = ['name','account_id','account_second_id'];


    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function account_second()
    {
        return $this->belongsTo(Account::class);
    }

}
