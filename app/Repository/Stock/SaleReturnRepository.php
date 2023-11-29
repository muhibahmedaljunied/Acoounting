<?php

namespace App\Repository\Stock;
use App\Traits\Sale\SaleReturnTrait;
use App\Services\CoreService;
use DB;
class SaleReturnRepository
{

use SaleReturnTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }

  
    
    public function add()
    {


        $this->add_into_sale_return_table($this->core);
     

    }

    public function init_details(...$list_data)
    {

        $this->add_into_sale_return_details_table($this->core);
  
    }

        function refresh_details()
    {

        $this->refresh_sale_return_details_table();


    }

   

   
}
