<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Sale\SaleTrait;
use App\Services\CoreService;
class SaleDetailRepository implements DetailRepositoryInterface
{

use SaleTrait;
    public $core;
    public function __construct()
    {
 
        $this->core = app(CoreService::class);
    }
  
    public function init_details(...$list_data)
    {
  
        $this->add_into_sale_details_table();
        
    }


}
