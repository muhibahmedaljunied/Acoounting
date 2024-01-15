<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\Traits\Sale\SaleReturnTrait;
use App\Services\CoreService;
use DB;
class SaleReturnRepository implements DetailRepositoryInterface,DetailRefreshRepositoryInterface
{

use SaleReturnTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }

  
    
    public function add()
    {


        $this->add_into_sale_return_table();
     

    }

    public function refresh()
    {


        $this->refresh_sale_return_table();
     

    }


    public function init_details(...$list_data)
    {

        $this->add_into_sale_return_details_table();
  
    }

        function refresh_details()
    {

        $this->refresh_sale_return_details_table();


    }

   

   
}
