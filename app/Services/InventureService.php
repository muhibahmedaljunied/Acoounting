<?php

namespace App\Services;

use App\Models\PurchaseDetail;
use DB;

class InventureService
{
    public $core;
  

    public function __construct()
    {
        $this->core = app(CoreService::class);
    }

    function refresh_price()
    {

        $qty = 0;
        $total = 0;
        $cost = 0;

        $data = PurchaseDetail::where('purchase_details.store_product_id', $this->core->id_store_product)
            ->select('purchase_details.*')
            ->get();

        if (count($data) > 1) {

            foreach ($data as $key => $value) {

                $qty += $value->qty;
                $total += $value->total;
            }

            $cost = $total / $qty;
            // dd($cost);

            DB::table('store_products')->where('store_products.id', $this->core->id_store_product)
                ->update(['cost' => $cost]);
        }
    }

}
