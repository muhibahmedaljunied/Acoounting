<?php

namespace App\Services;
class CoreService
{

    public $stock_f = 0;
    public $data;
    public $store_product_f = 0;
    public $unit_value;
    public $unit_array;
    public $micro_unit_qty;
    public $sale_id;
    public $return_id;
    public $purchase_id;
    public $id_store_product;
    public $value; 
    public $discount;

    public function setValue($value){

        $this->value = $value;
    }

    
    public function setData($data){

        $this->data = $data;
    }
    public function setDiscount($discount){

        $this->discount = $discount;
    }
   

}
