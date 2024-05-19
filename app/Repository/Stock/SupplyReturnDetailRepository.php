<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Supply\SupplyReturnTrait;
use App\Services\CoreService;

class SupplyReturnDetailRepository implements DetailRepositoryInterface
{

    use SupplyReturnTrait;

    public $core;
    public function __construct()
    {


        $this->core = app(CoreService::class);
    }




    public function init_details(...$list_data)
    {

        $this->add_into_supply_return_details_table();
    }


}
