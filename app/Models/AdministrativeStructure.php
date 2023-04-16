<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministrativeStructure extends Model
{
    // protected $fillable = ['structure_name_ar','structure_name_en','structure_main','rank','structure_type','parent_id'];

    public function children()
    {


        return $this->hasMany('App\Models\AdministrativeStructure', 'parent_id', 'id')->with('children');
    }


    public function staff()

    {

        return $this->hasOne(Staff::class);
    }
}
