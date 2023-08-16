<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\StockRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\StoreProductRepositoryInterface;
use App\RepositoryInterface\DailyReturnRepositoryInterface;
use App\Models\StoreProduct;
use App\Services\CoreService;
use App\Models\PurchaseDetail;
use App\Models\Purchase;
use App\RepositoryInterface\Daily;
use DB;

class PurchaseRepository extends Daily implements DailyReturnRepositoryInterface, StockRepositoryInterface, DetailRepositoryInterface, StoreProductRepositoryInterface
{



    public $core;
    public function __construct()
    {
        // $this->data_store = array(
        //     'count' => array(),
        //     'account_id' => array(),
        //     'description' => array(),
        //     'debit' => array(),
        //     'credit' => array(),
        //  );

        $this->core = app(CoreService::class);
    }

    public function add()
    {


        $table_one = Purchase::create(
            [
                'supplier_id' => $this->core->data['supplier_id'],
                'supplier_name' => $this->core->data['supplier_name'],
                'grand_total' => $this->core->data['grand_total'],
                'sub_total' => $this->core->data['sub_total'],
                'discount' => $this->core->discount,
                'tax_amount' => $this->core->data['total_tax'],
                'status' => 'pendding',
                'date' => $this->core->data['date'],

            ]
        );

        $this->core->purchase_id = $table_one->id;
        // return $table_one->id;
    }
    public function init_store_product()
    {


        $store_product = new StoreProduct();
        $store_product->product_id = $this->core->data['product'][$this->core->value];
        $store_product->store_id = $this->core->data['store'][$this->core->value];
        $store_product->status_id = $this->core->data['status'][$this->core->value];
        $store_product->desc = $this->core->data['desc'][$this->core->value];
        $store_product->quantity = $this->core->micro_unit_qty;
        $store_product->cost = $this->core->data['price'][$this->core->value];
        $store_product->save();
        // dd($store_product->id); 
        $this->core->id_store_product = $store_product->id;
    }
    public function get_store_product()
    {
    }
    public function refresh_store_product(...$list_data)
    {


        $this->core->store_product_f =  DB::table('store_products')
            ->where(['id' => $this->core->id_store_product])
            ->increment('quantity', $this->core->micro_unit_qty);
    }

    public function decode_unit()
    {

        $this->core->unit_array = json_decode($this->core->data['unit'][$this->core->value]);
        $this->core->unit_value = $this->core->unit_array[0];
        // dd($this->core->unit_value);

        return $this;
        // return $unit[0];

    }

    function convert_qty()
    {


        if ($this->core->unit_array[2] == 1) {  //this means unit_type

            $this->core->micro_unit_qty = $this->core->data['qty'][$this->core->value] * $this->core->unit_array[1];
        } else {
            $this->core->micro_unit_qty = $this->core->data['qty'][$this->core->value];
        }
        return $this;
    }



    public function init_details(...$list_data)
    {


        $Details = new PurchaseDetail();
        $Details->purchase_id = $this->core->purchase_id;
        $Details->price = $this->core->data['price'][$this->core->value];
        $Details->qty = $this->core->data['qty'][$this->core->value];
        $Details->total = $this->core->data['sub_total'];
        $Details->store_product_id = $this->core->id_store_product;
        $Details->unit_id = $this->core->unit_value;
        $Details->qty = $this->core->data['qty'][$this->core->value];

        $Details->save();
    }

    public function handle(){

        for ($i = 0; $i < 2; $i++) {

            $this->data_store['count'][$i] = $i;
             if ($i == 0) {
                
                $this->data_store['account_id'][$i] = $this->core->data['store_account'];
                $this->data_store['debit'][$i] = $this->core->data['paid'];
                $this->data_store['credit'][$i] = $this->core->data['remaining'];
            }

            if ($i == 1) {

               $this->payment($i);
            }
        }

    }
    public function payment($i)
    {

        $this->data_store['debit'][$i] = $this->core->data['remaining'];
        $this->data_store['credit'][$i] = $this->core->data['paid'];

        $this->set_acccount($i);
     
      
    }
}
