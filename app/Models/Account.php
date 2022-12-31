<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    protected $fillable = ['account_name_ar','account_name_en','currency','account_main','rank','account_type','parent_id'];

    public function children(){


        return $this->hasMany('App\Account', 'parent_id','id')->with('children');


    }

}
