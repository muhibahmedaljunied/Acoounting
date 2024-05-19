<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\Traits\Sale\SaleTrait;
use App\Services\CoreService;
class SaleRepository implements WarehouseRepositoryInterface
{

use SaleTrait;
    public $core;
    public function __construct()
    {
 
        $this->core = app(CoreService::class);
    }
    public function add()
    {

        $this->add_into_sale_table();
      
    }

    public function refresh()
    {


        $this->refresh_sale_table();
     

    }


  


}
