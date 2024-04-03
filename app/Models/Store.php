<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['store_name_ar','store_name_en','currency','store_main','rank','store_type','parent_id','account_id'];

    public function children(){


        return $this->hasMany('App\Models\Store', 'parent_id','id')->with('children');

    }


    public function daily()
    {
        return $this->morphMany(GroupAccount::class, 'dailyable');
    }
}