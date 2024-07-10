<?php

namespace App\Repository\StockInventury;

use App\Models\SupplyDetail;
use Illuminate\Support\Facades\DB;
class StockSupplyRepository extends StockRepository
{

   
   
   public function Stock()
    {


  
        // $this->refresh_price(); //this make refresh for cost of product

        $this->init_stock_table();
 
    }


    
    // function refresh_price()
    // {

    //     $qty = 0;
    //     $total = 0;
    //     $cost = 0;

    //     $data = SupplyDetail::where('supply_details.store_product_id', $this->core->id_store_product)
    //         ->select('supply_details.*')
    //         ->get();

            
    //     if (count($data) > 1) {

    //         foreach ($data as $key => $value) {

    //             $qty += $value->qty;
    //             $total += $value->total;
    //         }

    //         $cost = $total / $qty;
    //         // dd($cost);

    //         DB::table('store_products')->where('store_products.id', $this->core->id_store_product)
    //             ->update(['cost' => $cost]);
    //     }
    // }
    

   // }
    // }

   
}
