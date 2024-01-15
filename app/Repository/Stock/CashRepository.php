<?php

namespace App\Repository\Stock;
use App\Traits\Cash\CashTrait;
use App\Services\CoreService;
class CashRepository
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


    public function init_details(...$list_data)
    {
  
        $this->add_into_cash_details_table();
        
    }


}
