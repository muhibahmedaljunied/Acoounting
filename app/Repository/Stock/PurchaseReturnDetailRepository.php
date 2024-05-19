<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Purchase\PurchaseReturnTrait;
use App\Services\CoreService;

class PurchaseReturnDetailRepository implements DetailRepositoryInterface
{

    use PurchaseReturnTrait;

    public $core;
    public function __construct()
    {


        $this->core = app(CoreService::class);
    }

    public function init_details(...$list_data)
    {

        $this->add_into_purchase_return_details_table();
    }

    // public function refresh_details()
    // {


    //     $this->refresh_purchase_details_table();
    // }
}
