<?php

namespace App\Traits\Details;

use DB;
use App\Traits\Unit\UnitsTrait;

trait DetailsTrait
{
    use UnitsTrait;


    // function refresh_details(...$list_data)
    // {

    //     $data = $list_data['data'];
    //     $after_update = str_replace('Return', '', $data['type']);

    //     $type_column = strtolower($after_update);

    //     $condition = [
    //         'product_id' => $data['product_id'],
    //         'status_id' => $data['status_id'],
    //         'store_id' => $data['store_id'],
    //         'desc' => $data['desc'],
    //         'id' => $data['id']
    //         // $type_column.'_id' => $data['id']
    //     ];
    //     DB::table($type_column . '_details')->where($condition)->increment('qty_return', $data['qty']);
    // }



    public function details($request, $id)
    {
        // return response()->json(['details' => $request->all()]);
        $table = $request['table'];
        $output = explode('_', $table);
        $column = $output[0];

        //-----------------------------------------------------------------------------------------------
        $details =  DB::table($table)->where($table . '.' . $column . '_id', $id)
            // ->where('store_products.quantity', '!=', 0)
            ->join('units', $table.'.unit_id', '=', 'units.id')
            ->join('store_products', 'store_products.id', '=', $table . '.store_product_id')
            ->join('products','store_products.product_id', '=', 'products.id')
            ->join('statuses','store_products.status_id', '=', 'statuses.id')
            ->join('stores', 'store_products.store_id', '=', 'stores.id')
            
            ->select(
                'products.*',
                'products.text as product',
                'units.name as unit',
                $table . '.*',
                'store_products.*',
                'statuses.name as status',
                'stores.text as store',
                'store_products.quantity as avilable_qty',
                'store_products.desc',
                DB::raw($table . '.qty-' . $table . '.qty_return AS qty_remain')
            )
            ->get();

        foreach ($details as $value) {

            $value->qty_return_now = 0;
            $value->unit_selected = [];
        }
        $this->units($details);

        return $details;
  
    }
}