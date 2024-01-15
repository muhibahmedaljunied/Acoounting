<?php

namespace App\Repository\Stock;
use App\Traits\Sale\SaleTrait;
use App\Services\CoreService;
class SaleRepository
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


    public function init_details(...$list_data)
    {
  
        $this->add_into_sale_details_table();
        
    }


}
