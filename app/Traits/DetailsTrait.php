<?php

namespace App\Traits;

use DB;
use App\Models\TransferDetail;
use App\Models\SupplyDetail;
use App\Models\CashDetail;
use App\Models\SaleDetail;
use App\Models\PurchaseDetail;
use App\Models\SupplyReturnDetail;
use App\Models\CashReturnDetail;
use App\Models\ReturnSaleDetail;
use App\Models\ReturnPurchaseDetail;


trait DetailsTrait
{

    function init_details($id, $id_store_product, $value, $type, $data = null)
    {

        // return response()->json(['rrx' =>$data]);
        // return ['rrxmuhib' =>$data['product_id'][$value]];

        switch ($type) {

            case 'transfer':

                $Details = new TransferDetail();
                $Details->transfer_id = $id;
                $Details->into_store = $data['intostore'][$value];
                $Details->store_product_id = $id_store_product;
                $Details->product_id = $data['product_id'][$value];
                $Details->status_id = $data['status_id'][$value];
                $Details->store_id = $data['store_id'][$value];
                $Details->desc = $data['desc'][$value];
                $Details->qty = $data['qty'][$value];
                $Details->save();

                return;
                break;
            case 'supply':

                $Details = new SupplyDetail();
                $Details->supply_id = $id;

                break;

            case 'cash':

                $Details = new CashDetail();
                $Details->cash_id = $id;

                break;


            case ($type == 'purchase' || $type == 'sale'):

                if ($type == 'purchase') {
                    $Details = new PurchaseDetail();
                    $Details->purchase_id = $id;
                } else {
                    $Details = new SaleDetail();
                    $Details->sale_id = $id;
                }
                $Details->price = $value['price'];
                $Details->qty = $value['qty'];
                $Details->total = $value['sub_total'];

                break;

            case ($type == 'return_supply'):

                $Details = new SupplyReturnDetail();
                $Details->supply_return_id = $id;

                break;

            case ($type == 'return_cash'):

                $Details = new CashReturnDetail();
                $Details->cash_return_id = $id;

                break;
            case ($type == 'return_sale'):

                $Details = new ReturnSaleDetail();
                $Details->sale_return_id = $id;
                break;

            case ($type == 'return_purchase'):

                $Details = new ReturnPurchaseDetail();
                $Details->purchase_return_id = $id;
                break;
        }

        $Details->store_product_id = $id_store_product;
        $Details->product_id = $value['product_id'];
        $Details->status_id = $value['status_id'];
        $Details->store_id = $value['store_id'];
        $Details->desc = $value['desc'];
        $Details->qty = $value['qty'];

        $Details->save();
    }

    // public function get_details($id)
    // {

    //     // $supply_details = SupplyDetail::where('supply_details.supply_id', $id)
    //     $details = StoreProduct::where('supply_details.supply_id', $id)
    //         ->join('supply_details', 'store_products.id', '=', 'supply_details.store_product_id')
    //         ->joinall()
    //         ->select('products.*', 'products.text as product', 'supply_details.*', 'statuses.*', 'statuses.name as status', 'stores.*', 'stores.text as store', 'store_products.quantity as avilable_qty', DB::raw('supply_details.qty-supply_details.qty_return AS qty_remain'))
    //         ->get();

    //     return response()->json(['details' => $details]);
    // }
}
