<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Supply\SupplyReturnTrait;
use App\Traits\Supply\SupplyDetailsTrait;
use App\Services\CoreService;

class SupplyReturnDetailRepository implements DetailRepositoryInterface
{

    use SupplyReturnTrait,SupplyDetailsTrait;

    public $core;
    public function __construct()
    {


        $this->core = app(CoreService::class);
    }




    public function details(...$list_data)
    {

        $this->add_into_supply_return_details_table();
        $this->refresh_qty_return_supply_details();

    }


}
