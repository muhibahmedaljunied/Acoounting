<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\Traits\Sale\SaleReturnTrait;
use App\Services\CoreService;
use DB;
class SaleReturnRepository implements WarehouseRepositoryInterface
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


}
