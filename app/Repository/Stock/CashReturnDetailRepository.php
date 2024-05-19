<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Cash\CashReturnTrait;
use App\Services\CoreService;
class CashReturnDetailRepository implements DetailRepositoryInterface
{

use CashReturnTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }



    public function init_details(...$list_data)
    {

        $this->add_into_cash_return_details_table();
  
    }

 

   

   
}
