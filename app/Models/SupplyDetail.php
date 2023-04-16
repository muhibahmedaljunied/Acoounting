<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyDetail extends Model
{
    protected $fillable = [
        'supply_id','product_id', 'product_name','quantity'
    ];

    public function scopeJoinall($query)

    {

        return $query->join('products', 'store_products.product_id', '=', 'products.id')
                     ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
                     ->join('stores', 'store_products.store_id', '=', 'stores.id')
                     ->join('units', 'store_products.unit_id', '=', 'units.id');
             

    }

    public function scopeWheresupply($query,$value)

    {

        return $query ->where('product_id', $value['product_id'])
                      ->where('status_id', $value['status_id'])
                      ->where('store_id', $value['store_id'])
                      ->where('unit_id', $value['unit_id'])
                      ->where('supply_id', $value['supply_id'])
                      ->where('desc', $value['desc']);

    }

    
    public function scopeJoinsupply($query)

    {

        return $query->join('supplies', 'supplies.id', '=', 'supply_details.supply_id')
                    ->join('products', 'products.id', '=', 'supply_details.product_id')
                    ->join('stores', 'stores.id', '=', 'supply_details.store_id')
                    ->join('statuses', 'statuses.id', '=', 'supply_details.status_id')
                    ->join('units', 'units.id', '=', 'supply_details.unit_id');

    }
    



    




   
}
