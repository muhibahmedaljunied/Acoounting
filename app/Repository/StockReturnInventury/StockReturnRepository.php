<?php

namespace App\Repository\StockReturnInventury;
use App\Models\Stock;
use App\Services\CoreService;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;

 class StockReturnRepository
{

    public function __construct(protected CoreService $core)
    {
    }



    function init_stock_table()
    {

        if ($this->core->stock_f != 0) {
            return 0;
        }
        $stocks = new Stock();
        $stocks->store_product_id = $this->core->id_store_product;
        $stocks->unit_id = $this->core->unit_array[0];
        $stocks->quantity = $this->core->micro_unit_qty;
        $stocks->date = $this->core->data['date'];
        $stocks->stockable()->associate($this->core->stockable);
        $stocks->save();

        


        // }
    }

    // function refresh_price()
    // {

    //     $qty = 0;
    //     $total = 0;
    //     $cost = 0;

    //     $data = PurchaseDetail::where('purchase_details.store_product_id', $this->core->id_store_product)
    //         ->select('purchase_details.*')
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
}
