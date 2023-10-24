<?php

namespace App\Repository\Return;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\ReturnRepositoryInterface;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\RepositoryInterface\UnitRepositoryInterface;
use App\RepositoryInterface\DailyRepositoryInterface;
use App\Models\SaleReturnDetail;
use App\Models\SaleReturn;
use App\Services\CoreService;
use App\Models\Daily;
use App\Traits\DailyTrait;


use DB;

class SaleReturnRepository extends Daily implements DailyRepositoryInterface, WarehouseRepositoryInterface, DetailRepositoryInterface, ReturnRepositoryInterface, DetailRefreshRepositoryInterface
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
                $this->daily->payment($i);
            }
        }

        // dd($this->daily->data_store);

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
        $return = new SaleReturn();
        $return->sale_id = $this->core->data['sale_id'];
        $return->date  = $this->core->data['date'];
        // $return->quantity = $request->post('total');
        // $return->note  = $request['note'];
        $return->save();
        $this->core->return_id = $return->id;
    }
 

    public function init_details(...$list_data)
    {



        // $data = $this->core->data;


        $Details = new SaleReturnDetail();
        $Details->sale_return_id = $this->core->return_id;
        $Details->store_product_id = $this->core->id_store_product;
        $Details->unit_id = $this->core->unit_value;
        $Details->qty = $this->core->data['old'][$this->core->value]['qty_return_now'];
        $Details->save();
        // dd($Details->id);



    }
    function refresh_details()
    {



        DB::table('sale_details')
            ->where(['store_product_id' => $this->core->data['old'][$this->core->value]['store_product_id']])
            ->increment('qty_return', $this->core->data['old'][$this->core->value]['qty_return_now']);
        // dd($result);



    }

    public function check_detail()
    {

        $detail = DB::table('sale_return_details')
            ->select('sale_return_details.*')
            ->get();

        return $detail;
    }

    public function check_return($value)
    {

        $qty_return_now = $value['qty_return_now'];
        $qty_remain = $value['qty_remain'];
        $qty = $value['qty'];


        foreach ($value['units'] as $key => $values) {   //this for converts qty_return into micro unit

            //[0] =id,[1] = rate,[2] = unit_type
            if ($value['unit_selected'][2] == 1) {


                $qty_return_now = $value['qty_return_now'] * $value['rate'];
                $qty_remain = $value['qty_remain'] * $value['rate'];
                $qty = $value['qty'] * $value['rate'];
            }
        }

        // -------------------------------------------------------------------------------------------------------------------
        // if ($qty_return_now > $value['avilable_qty']) {
        //     return ['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المتوفره"];
        // }

        if ($qty_return_now > $qty_remain) {
            return ['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المسموح بها"];
        }

        if ($qty_return_now > $qty) {
            return ['message' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المباعه"];
        }

        if ($qty_remain == 0) {
            return ['message' => 0, 'text' => "لا يمكنك ارجاع كميه 0"];
        }
        $this->core->micro_unit_qty = $qty_return_now;
        return ['message' => 1, 'qty' => $qty_return_now];
    }

    // function store_return($request)
    // {

    //     $return = new SaleReturn();
    //     $return->sale_id = $request['id'];
    //     $return->date  = $request['date'];
    //     // $return->quantity = $request->post('total');
    //     $return->note  = $request['note'];
    //     $return->save();

    //     return $return->id;
    // }

    // public function refresh_store_product(...$list_data)
    // {


    //     $this->core->store_product_f =  DB::table('store_products')
    //         ->where(['id' => $this->core->id_store_product])
    //         ->increment('quantity', $this->core->micro_unit_qty);
    // }
   

       // public function decode_unit()
    // {

    //     $this->core->unit_array = $this->core->data['unit'][$this->core->value];
    //     $this->core->unit_value = $this->core->unit_array[0];
    //     // dd($this->core->unit_value);

    //     return $this;
    //     // return $unit[0];

    // }

    // function convert_qty()
    // {

    //     // dd($this->core->data['old'][$this->core->value]['qty_return_now']);

    //     if ($this->core->unit_array[2] == 1) {  //this means unit_type

    //         $this->core->micro_unit_qty = $this->core->data['old'][$this->core->value]['qty_return_now'] * $this->core->unit_array[1];
    //     } else {
    //         $this->core->micro_unit_qty = $this->core->data['old'][$this->core->value]['qty_return_now'];
    //     }
    //     return $this;
    // }


 
}
