<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'date','quantity',
    ];

    public function stock()
    {
        return $this->morphMany(Stock::class, 'stockable');
    }
}
