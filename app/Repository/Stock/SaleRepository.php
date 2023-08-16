<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\StoreProductRepositoryInterface;
use App\RepositoryInterface\DailyReturnRepositoryInterface;

use App\RepositoryInterface\Daily;
use App\RepositoryInterface\StockRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Services\CoreService;

use DB;


class SaleRepository extends Daily implements DailyReturnRepositoryInterface, StockRepositoryInterface, DetailRepositoryInterface, StoreProductRepositoryInterface
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
        // );
        $this->core = app(CoreService::class);
    }
    public function add()
    {


        // $array_unit_after_decode = $data['unit'][$value];
        $table_one = new Sale();
        $table_one->customer_id =  $this->core->data['customer_id'];
        $table_one->customer_name =  $this->core->data['customer_name'];
        $table_one->grand_total  = $this->core->data['grand_total'];
        $table_one->sub_total  = $this->core->data['sub_total'];
        $table_one->discount = $this->core->discount;
        $table_one->tax_amount  = $this->core->data['total_tax'];
        $table_one->status = 'pendding';
        $table_one->date =  $this->core->data['date'];
        $table_one->save();
        $this->core->sale_id = $table_one->id;

        // return $table_one->id;
    }

    public function init_store_product()
    {
    }
    public function get_store_product()
    {
    }
    public function refresh_store_product(...$list_data)
    {

        $this->core->store_product_f =  DB::table('store_products')
            ->where(['id' => $this->core->id_store_product])
            ->decrement('quantity', $this->core->micro_unit_qty);
    }

    public function decode_unit()
    {

        $this->core->unit_array = $this->core->data['unit'][$this->core->value];
        $this->core->unit_value = $this->core->unit_array[0];
        return $this;
    }



    function convert_qty()
    {


        if ($this->core->unit_array[2] == 0) {  //this means unit_type

            $micro_unit_qty = $this->core->data['qty'][$this->core->value];
        } else {

            $micro_unit_qty = $this->core->data['qty'][$this->core->value] * $this->core->unit_array[1];
        }
        $this->core->micro_unit_qty = $micro_unit_qty;
        return $this;
    }



    public function init_details(...$list_data)
    {

        $Details = new SaleDetail();
        $Details->sale_id = $this->core->sale_id;
        $Details->price = $this->core->data['old'][$this->core->value]['cost'];
        $Details->qty = $this->core->data['qty'][$this->core->value];
        $Details->total = $this->core->data['sub_total'];
        $Details->store_product_id = $this->core->id_store_product;

        $Details->unit_id = $this->core->unit_value;
        $Details->qty = $this->core->data['qty'][$this->core->value];

        $Details->save();
    }

    public function handle(){

        for ($i = 0; $i < 4; $i++) {

            $this->data_store['count'][$i] = $i;
            // $this->daily->data_store['account_id'][$i] = $this->core->data['store_account'];
           
            if ($i == 0) {
                
                $this->data_store['account_id'][$i] = $this->core->data['store_account'];
                $this->data_store['debit'][$i] = $this->core->data['remaining'];
                $this->data_store['credit'][$i] = $this->core->data['paid'];
    
            }

            if ($i == 1) {
                // $this->daily->data_store['account_id'][$i] =$this->get_account_sale_cost();
                $this->data_store['account_id'][$i] =42;
                $this->data_store['debit'][$i] = $this->core->data['paid'];
                $this->data_store['credit'][$i] = $this->core->data['remaining'];


            }

            if ($i == 2) {
                // $this->daily->data_store['account_id'][$i] = $this->get_account_sale();
                $this->data_store['account_id'][$i] = 511;
                $this->data_store['debit'][$i] = $this->core->data['remaining'];
                $this->data_store['credit'][$i] = $this->core->data['paid'];

            }

            if ($i == 3) {
                $this->payment($i);
            }
        }

    }


    public function payment($i)
    {

        $this->data_store['debit'][$i] = $this->core->data['paid'];
        $this->data_store['credit'][$i] = $this->core->data['remaining'];

        $this->set_acccount($i);

   
    }

  


}
