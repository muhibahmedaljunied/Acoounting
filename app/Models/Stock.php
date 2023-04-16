<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [

        'product_id', 'quantity','unit_id','store_id','price'
    ];



     
    public function scopeJoinstock($query)

    {

        return $query->join('products', 'products.id', '=', 'stocks.product_id')
        ->join('statuses', 'statuses.id', '=', 'stocks.status_id')
        ->join('stores', 'stores.id', '=', 'stocks.store_id')
        ->join('units', 'units.id', '=', 'stocks.unit_id');
      

    }


    

}
