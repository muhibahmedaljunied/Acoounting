<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Sale\SaleDetailsTrait;
use App\Services\CoreService;
class SaleDetailRepository implements DetailRepositoryInterface
{

use SaleDetailsTrait;
    public $core;
    public function __construct()
    {
 
        $this->core = app(CoreService::class);
    }
  
    public function details(...$list_data)
    {
  
        $this->add_into_sale_details_table('');
        
    }


}
