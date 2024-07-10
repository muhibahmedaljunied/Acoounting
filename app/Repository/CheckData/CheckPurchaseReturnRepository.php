<?php

namespace App\Repository\CheckData;
use App\Services\CoreService;
// use App\Traits\DailyTrait;
use DB;
class CheckPurchaseReturnRepository

{

    // use DailyTrait;

    public $qty_return_now = 0;
    public $qty_remain = 0;
    public $qty = 0;
    public $error;
    public $core;
    public function __construct()
    {
        $this->core = app(CoreService::class);
    }



    public function check_return($value)
    {

        foreach ($value['units'] as $values) {    //this for converts qty_return into micro unit



            $this->set_qty($value, $values);
            // dd($this->qty_return_now,$this->qty_remain, $this->qty);
            $this->message();
            if ($this->error != 0) {return $this->error;}
        }

     

        $this->core->micro_unit_qty = $this->qty_return_now;
        return ['status' => 1, 'qty' => $this->qty_return_now];
    }

    public function set_qty($value, $values)
    {

           $this->unit_of_origin_qty($value,$values);
           $this->unit_of_current_qty($value,$values);


    }




    public function unit_of_origin_qty($value,$values){

     

        if ($value['unit'] == $values['name']) {

     

            if ($values['unit_type'] == 1) {

                $this->qty_remain = $value['qty_remain'] * $value['rate'];
                $this->qty = $value['qty'] * $value['rate'];

              
            }

            if ($values['unit_type'] == 0) {

                
                $this->qty_remain = $value['qty_remain'];
                $this->qty = $value['qty'];

            }


        }



    }

    public function unit_of_current_qty($value,$values){
        
 
        
        // dd(intval($value['qty_return_now']));
        if ($value['unit_selected'][2] == $values['unit_type']) {


       

            if ($value['unit_selected'][2] == 1) {

             
                $this->qty_return_now = $value['qty_return_now'] * $value['rate'];

            }

            if ($value['unit_selected'][2] == 0) {

           
                $this->qty_return_now = $value['qty_return_now'];

            }



        }



    }

    public function message()
    {

        if ($this->qty_return_now > $this->qty_remain) {

            $this->error =  ['status' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  الكميه المسموح بها"];
        }

        if ($this->qty_return_now > $this->qty) {
            $this->error =  ['status' => 0, 'text' => "لا يمكنك ارجاع كميه اكبر من  كميه الشراء"];
        }

        if ($this->qty_remain == 0 ) {

            $this->error =  ['status' => 0, 'text' => "لا يمكنك ارجاع اي كميه لقد ارجعت  الكميه كامله"];
        }

        if ($this->qty_return_now == 0) {

            $this->error =  ['status' => 0, 'text' => "لا يمكنك ارجاع كميه 0"];
        }

    }








    
    // public function set_qty($value)
    // {

    //     if ($value['unit_selected'][2] == 1) {


    //         $this->qty_return_now = $value['qty_return_now'] * $value['rate'];
    //         $this->qty_remain = $value['qty_remain'] * $value['rate'];
    //         $this->qty = $value['qty'] * $value['rate'];
    //     } else {

    //         $this->qty_return_now = $value['qty_return_now'];
    //         $this->qty_remain = $value['qty_remain'];
    //         $this->qty = $value['qty'];
    //     }
    // }

  
}
