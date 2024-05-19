<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\Traits\Cash\CashTrait;
use App\Services\CoreService;
class CashRepository implements WarehouseRepositoryInterface
{

use CashTrait;
    public $core;
    public function __construct()
    {
 
        $this->core = app(CoreService::class);
    }
    public function add()
    {

        $this->add_into_cash_table();
      
    }

    public function refresh()
    {


        $this->refresh_cash_table();
     

    }




}
