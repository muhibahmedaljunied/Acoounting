<?php

namespace App\Traits\Details;

use Illuminate\Support\Facades\DB;
use App\Traits\Unit\UnitsTrait;
use Illuminate\Http\Request;

trait DetailsTrait
{
    use UnitsTrait;



    public function get_details(Request $request, $id)
    {


        
        $table = $request['table'];
        $output = explode('_', $table);
        $column = $output[0];

        //-----------------------------------------------------------------------------------------------
        $this->qty->details =   DB::table($table)->where($table . '.' . $column . '_id', $id)
            // ->where('store_products.quantity', '!=', 0)
            // ->join('units', $table.'.unit_id', '=', 'units.id')
            ->join('store_products', 'store_products.id', '=', $table . '.store_product_id')
            ->join('products','store_products.product_id', '=', 'products.id')
            ->join('statuses','store_products.status_id', '=', 'statuses.id')
            ->join('stores', 'store_products.store_id', '=', 'stores.id')
            
            ->select(
                'products.*',
                'products.text as product',
                // 'units.name as unit',
                $table . '.*',
                'store_products.*',
                'statuses.name as status',
                'stores.text as store',
                'stores.account_id as store_account_id',
                'store_products.quantity as avilable_qty',
                'store_products.desc',
                DB::raw($table . '.qty-' . $table . '.qty_return AS qty_remain')
            )
            ->get();

          

        foreach ($this->qty->details as $value) {

            $value->qty_return_now = 0;
            $value->unit_selected = [];
        }

  
    }


    public function get_return_details($id,$table,$tables)
    {


        $this->qty->details = DB::table($table)
            ->where($tables . '_return_details.' . $tables . '_return_id', $id)
            ->join($tables . '_returns', $tables . '_returns.' . $tables . '_id', '=', $table . '.id')
            ->join($tables . '_return_details', $tables . '_returns.id', '=', $tables . '_return_details.' . $tables . '_return_id')
            // ->join('units', $tables . '_return_details.unit_id', '=', 'units.id')
            ->join('store_products', 'store_products.id', '=', $tables . '_return_details.store_product_id')
            ->join('products', 'store_products.product_id', '=', 'products.id')
            ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
            ->join('stores', 'store_products.store_id', '=', 'stores.id')
            ->select(
                'store_products.*',
                $tables . '_return_details.*',
                'products.*',
                // 'product_units.rate',
                // 'units.name as unit',
                $tables . '_return_details.qty as qty_return',
                $tables . '_returns.*',
                'statuses.*',
                'statuses.name as status',
                'stores.*',
                'products.text as product_name'
            )
            ->get();


    }
}
