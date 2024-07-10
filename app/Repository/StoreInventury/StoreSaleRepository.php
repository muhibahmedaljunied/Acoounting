<?php


namespace App\Repository\StoreInventury;

use App\RepositoryInterface\StoreRepositoryInterface;
use App\Services\CoreService;

class StoreSaleRepository extends StoreRepository implements StoreRepositoryInterface
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
  
 




}
