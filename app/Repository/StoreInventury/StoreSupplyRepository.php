<?php


namespace App\Repository\StoreInventury;
use App\RepositoryInterface\StoreRepositoryInterface;
use App\Services\CoreService;

class StoreSupplyRepository extends StoreRepository implements StoreRepositoryInterface
{

  public function __construct(CoreService $core)
  {
    $this->core = $core;
    $this->operation = 'increment';
  }
  public function store()
  {

    $this->get_store_product_tow();
    $this->check_founded_store();
  
  }

  
  public function check_founded_store()
  {


      if ($this->core->id_store_product == 0) {


          $this->init_store_product_table();

      } else {


          $this->refresh_store_product();
      }



  }

  public function refresh_store_product()
  {



          $this->refresh_qty_store_product_table();
          $this->refresh_total_store_product_table();
          $this->get_store_product_tow();
          $this->refresh_cost_store_product_table();
  }
  
    
    // public function __construct(CoreService $core)
    // {
  
    //   $this->core = $core;
    //   $this->operation = 'increment';
    // }
    
    // public function store()
    // {

    //     $this->get_store_product_one_table();
    //     $this->init_store_product();
    //     $this->refresh_store_product();
    //     $this->get_store_product_table();

    //     if ($this->init_status == true) {


    //       $this->refresh_cost_store_product_table();
    
    //       }
          
    // }


    
    // function get_store_product()
    // {

    //      $this->get_store_product_table();
             
    //     $this->core->id_store_product = ($this->core->data_store_product == null) ? 0 : $this->core->data_store_product[0]['id'];

       
    // }

    // public function handle_cost_store_product($operation)
    // {
  
  
    //   if ($this->init_status == true) {


    //   $this->get_store_product_table($operation);
    //   $this->refresh_cost_store_product_table($operation);

    //   }

    // }
  
  }