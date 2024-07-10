<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['id','text','parent_id','account_id','rank','status','created_at','updated_at'];

    public function children(){


        return $this->hasMany('App\Models\Store', 'parent_id','id')->with('children');

    }


    public function daily()
    {
        return $this->morphMany(GroupAccount::class, 'dailyable');
    }
}