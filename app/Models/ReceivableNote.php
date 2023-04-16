<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ReceivableNote extends Model
{
    protected $fillable = ['sale_id','date','paid'];


    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
