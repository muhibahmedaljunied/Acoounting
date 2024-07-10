<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Cash\CashReturnTrait;
use App\Traits\Cash\CashDetailsTrait;
use App\Services\CoreService;
class CashReturnDetailRepository implements DetailRepositoryInterface
{

use CashReturnTrait,CashDetailsTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }



    public function details(...$list_data)
    {

        $this->add_into_cash_return_details_table();
        $this->refresh_qty_return_cash_details();

  
    }

 

   

   
}
