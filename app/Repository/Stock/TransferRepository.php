<?php

namespace App\Repository\Stock;

use App\Models\Transfer;
use App\Models\TransferDetail;
use App\Models\StoreProduct;
use App\RepositoryInterface\StockRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\StoreProductRepositoryInterface;

use App\Services\CoreService;
use DB;

class TransferRepository implements StockRepositoryInterface, DetailRepositoryInterface, StoreProductRepositoryInterface
{

    public $core;



    public function __construct()
    {
        $this->core = app(CoreService::class);
    }

    public function add()
    {


        $table_one = new Transfer();
        $table_one->date =  $this->core->data['date'];
        $table_one->save();
        $this->core->transfer_id = $table_one->id;
    }

    public function init_store_product()
    {

        // dd($this->core->data['old']);
        $store_product = new StoreProduct();
        $store_product->product_id = $this->core->data['old'][$this->core->value]['product_id'];
        $store_product->store_id = $this->core->data['into_store'];
        $store_product->status_id = $this->core->data['old'][$this->core->value]['status_id'];
        $store_product->desc = $this->core->data['old'][$this->core->value]['desc'];
        $store_product->quantity = $this->core->micro_unit_qty;
        $store_product->cost = $this->core->data['old'][$this->core->value]['cost'];
        $store_product->save();
        $this->core->id_store_product = $store_product->id;
    }
    public function get_store_product()
    {
    }

    public function refresh_store_product(...$list_data)
    {

        // $store_id = (isset($list_data['store_id'])) ? $list_data['store_id'] : $this->core->data['store'][$this->core->value];

        $type_refresh = $list_data['type_refresh'];
        // dd($type_refresh);
        // $store_id = $list_data['store_id'];
        if ($type_refresh == 'decrement') {
            
            $this->core->store_product_f =  DB::table('store_products')
            ->where(['id' => $this->core->id_store_product])
            ->decrement('quantity', $this->core->micro_unit_qty);
           
        }
        if ($type_refresh == 'increment') {

            $this->core->store_product_f =  DB::table('store_products')
            ->where(['store_id' => $this->core->data['intostore_id']])
            ->increment('quantity', $this->core->micro_unit_qty);
        }
    }

    public function decode_unit()
    {

        $this->core->unit_array = $this->core->data['unit'][$this->core->value];
        $this->core->unit_value = $this->core->unit_array[0];
        // dd($this->core->unit_array);

        return $this;
        // return $unit[0];

    }



    function convert_qty()
    {


        if ($this->core->unit_array[2] == 0) {  //this means unit_type

            $micro_unit_qty = $this->core->data['qty_transfer'][$this->core->value];
        } else {

            $micro_unit_qty = $this->core->data['qty_transfer'][$this->core->value] * $this->core->unit_array[1];
        }
        $this->core->micro_unit_qty = $micro_unit_qty;
        return $this;
    }


    public function init_details(...$list_data)
    {






        $unit_id = (isset($list_data['unit'])) ? $list_data['unit'] : $this->core->data['unit'][$this->core->value];

        $Details = new TransferDetail();
        $Details->transfer_id = $this->core->transfer_id;
        $Details->into_store = $this->core->data['intostore'];
        $Details->store_product_id = $this->core->id_store_product;

        // $Details->product_id = $this->core->data['product'][$this->core->value];
        // $Details->status_id = $this->core->data['status'][$this->core->value];
        // $Details->store_id = $this->core->data['store'][$this->core->value];
        // $Details->desc = $this->core->data['desc'][$this->core->value];

        $Details->unit_id = $unit_id[0];
        $Details->qty = $this->core->micro_unit_qty;

        $Details->save();
        // dd($Details->id);



    }
}
