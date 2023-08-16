<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreProduct extends Model
{
    protected $fillable = [
        'product_id', 'store_id',
    ];

    public function scopeJoinall($query)

    {

        return $query->join('products', 'store_products.product_id', '=', 'products.id')
                     ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
                     ->join('stores', 'store_products.store_id', '=', 'stores.id');
    }

    // public function scopeWhereall($query)

    // {

    //     return $query->where([
    //         'store_products.product_id' => $this->core->data['product'][$this->core->value],
    //         'store_products.store_id' => $this->core->data['store'][$this->core->value],
    //         'store_products.status_id' => $this->core->data['status'][$this->core->value],
    //         'store_products.desc' => $this->core->data['desc'][$this->core->value]
    //     ]);
    // }


   


    
}
