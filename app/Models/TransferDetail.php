<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferDetail extends Model
{
    protected $fillable = [
        'transfer_id', 'product_id', 'product_name', 'quantity'
    ];

    protected $casts = [
        'into_store' => 'array', // Will convarted to (Array)
        'into_shelve' => 'array', // Will convarted to (Array)
    ];


    public function scopeJointransfer($query)

    {

        return $query->join('products', 'transfer_details.product_id', '=', 'products.id')
            ->join('statuses', 'transfer_details.status_id', '=', 'statuses.id')
            ->join('stores', 'transfer_details.store_id', '=', 'stores.id')
            ->join('units', 'transfer_details.unit_id', '=', 'units.id');

    }

    public function scopeWhereall($query, $request, $value)

    {

        return $query->where([
            'product_id' => $request['product_id'][$value],
            'store_id' => $request['store_id'][$value],
            'unit_id' => $value['unit_id'], 
            'status_id' => $request['status_id'][$value],
            'desc' => $request['desc'][$value]
        ]);
    }
}
