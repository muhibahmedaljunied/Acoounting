<?php

namespace App\Services;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\RepositoryInterface\DailyReturnRepositoryInterface;
use App\Traits\DailyTrait;
use App\Services\InventureService;
use App\Services\CoreService;
class ReturnService
{

    use DailyTrait;
    public $core;
    public function __construct(
        protected DetailRepositoryInterface $details,
        protected DetailRefreshRepositoryInterface $refresh,
        protected DailyReturnRepositoryInterface $daily,
        protected InventureService $inventure,

    ) {

        $this->core = app(CoreService::class);
        $this->core->store_product_f = 0;
        $this->core->stock_f = 0;
    }

    public function store()
    {

        $this->inventure->get_store()->refresh_store(); // this make updating for store_products
      
        return $this;
    }

    public function stock()
    {
        // $this->inventure->refresh_stock()->init_stock(); // this make update for stock table
        $this->inventure->init_stock(); // this make update for stock table


        return $this;
    }

    public function details()
    {

  
        $this->details->init_details(); // this make initial for details tables
      

        $this->refresh->refresh_details();
   
        return $this;
    }

    
    public function daily()
    {
       
        $this->daily->handle();
        $this->db_create()->db_store();

        // $this->daily->daily();
    }



   
}
