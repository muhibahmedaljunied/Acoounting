<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','product_main','rank','parent_id'];

    public function children(){


        return $this->hasMany('App\Models\Product', 'parent_id','id')->with('children');


    }
}
