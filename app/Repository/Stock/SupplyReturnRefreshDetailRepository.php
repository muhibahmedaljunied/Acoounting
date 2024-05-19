<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\Services\CoreService;
use App\Traits\Supply\SupplyTrait;
use DB;

class SupplyReturnRefreshDetailRepository implements DetailRefreshRepositoryInterface
{

    use SupplyTrait;

    public $core;
    public function __construct()
    {


        $this->core = app(CoreService::class);
    }



   

    public function refresh_details(...$list_data)
    {

        $this->refresh_supply_details_table();
    }


}
