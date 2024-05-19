<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Sale\SaleReturnTrait;
use App\Services\CoreService;
use DB;
class SaleReturnDetailRepository implements DetailRepositoryInterface
{

use SaleReturnTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }

  
    



    public function init_details(...$list_data)
    {

        $this->add_into_sale_return_details_table();
  
    }

 

   

   
}
