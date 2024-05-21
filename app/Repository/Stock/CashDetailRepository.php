<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Cash\CashTrait;
use App\Services\CoreService;

class CashDetailRepository implements DetailRepositoryInterface
{

    use CashTrait;
    public $core;
    public function __construct()
    {

        $this->core = app(CoreService::class);
    }

    public function init_details()
    {

   
        $this->add_into_cash_details_table();
    }
}
