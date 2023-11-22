<?php

namespace App\Services;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Services\InventureService;
use App\Services\CoreService;
use App\Traits\DailyTrait;

class ReturnService
{

    use DailyTrait;
    public $return_id;
    
    public $core;
    public function __construct(
        protected DetailRepositoryInterface $details,
        protected DetailRefreshRepositoryInterface $refresh,
        protected InventureService $inventure,
 


    ) {

        $this->core = app(CoreService::class);
        $this->core->store_product_f = 0;
        $this->core->stock_f = 0;
    }



    public function details()
    {

  
        $this->details->init_details(); // this make initial for details tables
      

        $this->refresh->refresh_details();
   
        return $this;
    }

   



   
}
