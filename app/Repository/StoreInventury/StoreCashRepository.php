<?php


namespace App\Repository\StoreInventury;
use App\RepositoryInterface\StoreRepositoryInterface;
use App\Services\CoreService;

class StoreCashRepository extends StoreRepository  implements StoreRepositoryInterface
{


    public function __construct(CoreService $core)
    {
      $this->core = $core;
      $this->operation = 'decrement';
    }
    public function store()
    {
        
  
      $this->get_store_product_first();
      $this->refresh_store_product();

    
    }
  

  
    public function refresh_store_product()
    {
  
  
  
            $this->refresh_qty_store_product_table();
            $this->refresh_total_store_product_table();
            $this->get_store_product_first();
            $this->refresh_cost_store_product_table();
            
    }
    
    // public function __construct(CoreService $core)
    // {
    //   $this->core = $core;
    //   $this->operation = 'decrement';
    // }
    

    // public function store()
    // {


    //     $this->refresh_store_product(); // this make refresh for store_products
    //     $this->get_store_product_tow_table();
    //     if ($this->init_status == true) {

    //         $this->refresh_cost_store_product_table();
    //     }
    // }

    // public function handle_cost_store_product($operation)
    // {


    //     if ($this->init_status == true) {

    //         //   $this->get_store_product_table($operation);
    //         $this->refresh_cost_store_product_table($operation);
    //     }
    // }





    // function get_store_product()
    // {

    //      $this->get_store_product_table();

    //     $this->core->id_store_product = ($this->core->data_store_product == null) ?0 : $this->core->data_store_product[0]['id'];





    // }





}
