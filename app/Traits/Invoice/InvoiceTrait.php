<?php

namespace App\Traits\Invoice;

use Illuminate\Support\Facades\DB;

trait InvoiceTrait
{


    public function invoice($id, $table)
    {
        $output = explode('_', $table);
        $column = $output[0];
        //-----------------------------------------------------------------------------------------------
        $details = DB::table($table)->where($table . '.' . $column . '_id', $id)
            ->join('units', $table . '.unit_id', '=', 'units.id')
            ->where('store_products.quantity', '!=', 0)
            ->join('store_products', 'store_products.id', '=', $table . '.store_product_id')
            ->join('products', 'store_products.product_id', '=', 'products.id')
            ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
            ->join('stores', 'store_products.store_id', '=', 'stores.id')
            // ->join('units', $table . '.unit_id', '=', 'units.id')
            ->select('store_products.*','products.*', 'products.text as product', 'units.name as unit', $table . '.*', 'statuses.name as status', 'stores.text as store', 'store_products.quantity as avilable_qty', 'store_products.desc', DB::raw($table . '.qty-' . $table . '.qty_return AS qty_remain'))
            // ->select('products.*','products.text as product', 'purchase_details.*', 'statuses.*', 'statuses.name as status','units.name as unit', 'stores.*','stores.text as store', 'store_products.quantity as avilable_qty', 'store_products.desc', DB::raw('purchase_details.qty-purchase_details.qty_return AS qty_remain'))
            ->get();

            // dd($details);
        // $this->units($details);

        foreach ($details as $key => $value) {

            $units = DB::table('product_units')
                ->join('units', 'units.id', '=', 'product_units.unit_id')
                ->join('products', 'products.id', '=', 'product_units.product_id')
                ->where('product_units.product_id', $value->product_id)
                ->select('units.*', 'product_units.rate', 'product_units.unit_type')
                ->get();

            $value->units = $units;
        }


        return $details;
    }
}
