<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $fillable = ['sale_id','product_id','quantity','price','total','qty_return'];


    public function scopeWheresale($query,$value)

    {

        return $query->where('product_id', $value['product_id'])
                    ->where('status_id', $value['status_id'])
                    ->where('store_id', $value['store_id'])
                    ->where('sale_id', $value['sale_id']);

    }


    public function scopeJoinsale($query)

    {

        return $query->join('products', 'sale_details.product_id', '=', 'products.id')
        ->join('statuses', 'sale_details.status_id', '=', 'statuses.id')
        ->join('stores', 'sale_details.store_id', '=', 'stores.id');
 

    }



    


    
}
