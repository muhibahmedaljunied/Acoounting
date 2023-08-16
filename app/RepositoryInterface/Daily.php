<?php
namespace App\RepositoryInterface;
abstract class Daily{

    // public $data_store;

    public $data_store = array(
        'count' => array(),
        'account_id' => array(),
        'description' => array(),
        'debit' => array(),
        'credit' => array(),
     );

     public function set_acccount($i){

        if ($this->core->data['type_payment'] == 1) {
            $this->data_store['account_id'][$i] = $this->core->data['treasury_account'];
        }
        if ($this->core->data['type_payment'] == 2) {
            $this->data_store['account_id'][$i] = $this->core->data['supplier_account'];
        }
        
     }

    // abstract function payment($i);


}
