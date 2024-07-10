<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffSanction extends Model
{

  
    protected $fillable = ['id','staff_id','sanctionable_type','sanctionable_id','date','status'];


    public function sanctionable()
  {
    //   return $this->morphTo('App\AbsenceSanction','App\DelaySanction','App\ExtraSanction','App\LeaveSanction');
      return $this->morphTo();

  }

  public function staff()
  {
      return $this->belongsTo(Staff::class);
  }

  

}
