<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\Traits\Cash\CashReturnTrait;
use App\Services\CoreService;
class CashReturnRepository implements WarehouseRepositoryInterface
{

use CashReturnTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }

  
    
    public function add()
    {


        $this->add_into_cash_return_table();
     

    }

    public function refresh()
    {


        $this->refresh_cash_return_table();
     

    }


 

   

   
}
