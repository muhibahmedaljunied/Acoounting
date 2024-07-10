<?php

namespace App\Repository\Stock;

use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Cash\CashDetailsTrait;
use App\Services\CoreService;

class CashDetailRepository implements DetailRepositoryInterface
{

    use CashDetailsTrait;
    public $core;
    public function __construct()
    {

        $this->core = app(CoreService::class);
    }

    public function details()
    {

   
        $this->add_into_cash_details_table();
    }
}
