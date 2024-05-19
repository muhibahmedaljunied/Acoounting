<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\Traits\Cash\CashReturnTrait;
use App\Services\CoreService;
use App\Traits\Cash\CashTrait;

class CashReturnRefreshDetailRepository implements DetailRefreshRepositoryInterface
{

use CashTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }

  

        function refresh_details()
    {

        $this->refresh_cash_details_table();


    }

   

   
}
