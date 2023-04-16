<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $fillable = [
        'purchase_id','store_product_id','product_id','store_id','status_id','product_name','quantity','price','total','qty_return'
    ];


    public function scopeWherepurchase($query,$value)

    {

        return $query->where('product_id', $value['product_id'])
                      ->where('status_id', $value['status_id'])
                      ->where('store_id', $value['store_id'])
                      ->where('unit_id', $value['unit_id'])
                      ->where('purchase_id', $value['purchase_id']);

    }


    public function scopeJoinpurchase($query)

    {

        return $query->join('products', 'purchase_details.product_id', '=', 'products.id')
        ->join('statuses', 'purchase_details.status_id', '=', 'statuses.id')
        ->join('stores', 'purchase_details.store_id', '=', 'stores.id')
        ->join('units', 'purchase_details.unit_id', '=', 'units.id');
    

    }



    


   
}
