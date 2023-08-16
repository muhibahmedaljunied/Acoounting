<?php

namespace App\Repository\Return;
use App\RepositoryInterface\StoreProductRepositoryInterface;
use App\RepositoryInterface\DailyReturnRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\RepositoryInterface\ReturnRepositoryInterface;
use App\RepositoryInterface\StockRepositoryInterface;
use App\Models\PurchaseReturn;
use App\Services\CoreService;
use App\RepositoryInterface\Daily;
use App\Models\PurchaseReturnDetail;

use App\Traits\DailyTrait;

use DB;

class PurchaseReturnRepository extends Daily implements DailyReturnRepositoryInterface,  StockRepositoryInterface, DetailRepositoryInterface, ReturnRepositoryInterface, DetailRefreshRepositoryInterface, StoreProductRepositoryInterface
{

    use DailyTrait;

    public $core;
    public function __construct()
    {
        $this->core = app(CoreService::class);
    }


    function handle()
    {
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
                $this->data_store['account_id'][$i] = 42;
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

        dd($this->data_store);

        // $this->db_create()->db_store();
    }

    public function payment($i)
    {

        $this->data_store['debit'][$i] = $this->core->data['remaining'];
        $this->data_store['credit'][$i] = $this->core->data['paid'];
        
        $this->set_acccount($i);
        // if ($this->core->data['type_payment'] == 1) {
        //     $this->data_store['account_id'][$i] = $this->core->data['treasury_account'];
        // }
        // if ($this->core->data['type_payment'] == 2) {
        //     $this->data_store['account_id'][$i] = $this->core->data['supplier_account'];
        // }
      
    }

    function add()
    {
        $return = new PurchaseReturn();
        $return->purchase_id = $this->core->data['purchase_id'];
        $return->date  = $this->core->data['date'];
        // $return->quantity = $request->post('total');
        // $return->note  = $request['note'];
        $return->save();
        $this->core->return_id = $return->id;
    }


    public function init_details(...$list_data)
    {


        $Details = new PurchaseReturnDetail();
        $Details->purchase_return_id = $this->core->return_id;
        $Details->store_product_id = $this->core->id_store_product;
        $Details->unit_id = $this->core->unit_value;
        $Details->qty = $this->core->data['old'][$this->core->value]['qty_return_now'];
        $Details->save();
    }
    public function refresh_store_product(...$list_data)
    {


        $this->core->store_product_f =  DB::table('store_products')
            ->where(['id' => $this->core->id_store_product])
            ->decrement('quantity', $this->core->micro_unit_qty);
    }
    public function init_store_product()
    {
    }

    public function get_store_product()
    {
    }

    public function decode_unit()
    {

        $this->core->unit_array = $this->core->data['unit'][$this->core->value];
        $this->core->unit_value = $this->core->unit_array[0];
        // dd($this->core->unit_value);

        return $this;
        // return $unit[0];

    }

    function convert_qty()
    {

        // dd($this->core->data['old'][$this->core->value]['qty_return_now']);

        if ($this->core->unit_array[2] == 1) {  //this means unit_type

            $this->core->micro_unit_qty = $this->core->data['old'][$this->core->value]['qty_return_now'] * $this->core->unit_array[1];
        } else {
            $this->core->micro_unit_qty = $this->core->data['old'][$this->core->value]['qty_return_now'];
        }
        return $this;
    }
    function refresh_details()
    {


        DB::table('purchase_details')
            ->where(['store_product_id' => $this->core->data['old'][$this->core->value]['store_product_id']])
            ->increment('qty_return', $this->core->data['old'][$this->core->value]['qty_return_now']);
        // dd($result);



    }




    public function check_return($value)
    {

        foreach ($value['units'] as $key => $values) {   //this for converts qty_return into micro unit

            //[0] =id,[1] = rate,[2] = unit_type
            if ($value['unit_selected'][2] == 1) {


                $qty_return_now = $value['qty_return_now'] * $value['rate'];
                $qty_remain = $value['qty_remain'] * $value['rate'];
                $qty = $value['qty'] * $value['rate'];
            }
        }

        // -------------------------------------------------------------------------------------------------------------------

        if ($qty_return_now > $qty_remain) {
            return ['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المسموح بها"];
        }

        if ($qty_return_now > $qty) {
            return ['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  كميه الشراء"];
        }

        if ($qty_remain == 0) {
            return ['message' => 0, 'text' => "لا يمكنك ارجاع كميه 0"];
        }
        $this->core->micro_unit_qty = $qty_return_now;
        return ['message' => 1, 'qty' => $qty_return_now];
    }

    public function check_detail()
    {

        $detail = DB::table('purchase_return_details')
            ->select('purchase_return_details.*')
            ->get();

        return $detail;
    }
}
