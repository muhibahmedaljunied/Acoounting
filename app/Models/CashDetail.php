<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashDetail extends Model
{
    protected $fillable = [
        'cash_id', 'product_id', 'product_name', 'quantity'
    ];


    public function scopeWherecash($query, $value)

    {


        return $query->where('product_id', $value['product_id'])
            ->where('status_id', $value['status_id'])
            ->where('store_id', $value['store_id'])
            ->where('unit_id', $value['unit_id'])
            ->where('desc', $value['desc'])
            ->where('cash_id', $value['cash_id']);
    }

    public function scopeJoincash($query)

    {


        return $query->join('cashes', 'cashes.id', '=', 'cash_details.cash_id')
            ->join('products', 'products.id', '=', 'cash_details.product_id')
            ->join('stores', 'stores.id', '=', 'cash_details.store_id')
            ->join('statuses', 'statuses.id', '=', 'cash_details.status_id')
            ->join('units', 'units.id', '=', 'cash_details.unit_id');
    }
}
