<?php

namespace App\Repository\StoreInventury;

use App\Services\CoreService;
use App\Traits\Transfer\StoreProductTrait;

class StoreTransferRepository extends StoreRepository
{

    use StoreProductTrait;
    public $store = '';
    public function __construct(CoreService $core)
    {
      $this->core = $core;
    }

    public function store()
    {

        // $this->refresh_store_product_transfer(['decrement', 'increment']);
        // --------------------------------------


        $this->handle_from_store();
        
        $this->handle_into_store();
        // dd(198);


    }


    public function handle_from_store()
    {

        $this->operation = 'decrement';
        $this->store = $this->core->data['old'][$this->core->value]['store_id'];
        $this->get_store_product_first();
        $this->refresh_store_product();

    }
    public function handle_into_store()
    {

        $this->operation = 'increment';
        $this->store = $this->core->data['intostore_id'];
        $this->get_store_product_table();
        $this->check_founded_store();
    }
    public function refresh_store_product()
    {



        $this->refresh_qty_store_product_table();
        $this->refresh_total_store_product_table();
        $this->get_store_product_table();
        $this->refresh_cost_store_product_table();
    }

    public function check_founded_store()
    {


        if ($this->core->id_store_product == 0) {


            $this->init_store_product_table();
        } else {


            $this->refresh_store_product();
        }
    }




  


}
