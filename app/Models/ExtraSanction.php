<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ExtraSanction extends Model
{
    protected $fillable = ['part_id','sanction_discount_id','extra_type_id','iteration','sanction'];


    public function scopeWhereExtraSanction($query, $value,$val)

    {
       
        return $query->where([
            'extra_type_id' => $value['extra'][$val],
            'iteration' => $value['iteration'][$val],
            'part_id' => $value['extra_part'][$val], 
            'sanction_discount_id' => $value['discount_type'][$val],
        ]);

                                                        
                                                            
    }


    // public function extra()
    // {
    //     return $this->hasMany(Extra::class);
    // }

    public function extra_detail()
    {
        return $this->hasMany(ExtraDetail::class);
    }



    public function staff_sanction()
    {
        return $this->morphMany(StaffSanction::class, 'sanctionable');
    }
  

}
