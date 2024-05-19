<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministrativeStructure extends Model
{
    protected $fillable = ['id','text','parent_id','rank','type_branch','status','created_at','updated_at'];

    public function children()
    {


        return $this->hasMany('App\Models\AdministrativeStructure', 'parent_id', 'id')->with('children');
    }


    public function staff()

    {

        return $this->hasOne(Staff::class);
    }
}
