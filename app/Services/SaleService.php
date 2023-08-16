<?php

namespace App\Services;

use App\Services\InventureService;
use App\Repository\Stock\SaleRepository;
use App\Traits\DailyTrait;
use App\Services\CoreService;


class SaleService
{

    use DailyTrait;
    public $request;
    public $sale_id = 0;
    public $temporale = 0;
    public $discount;
    public $core;
    public function __construct(
        protected InventureService $inventury,
        protected SaleRepository $daily


    ) {
        $this->core = app(CoreService::class);
    }

    public function Stock()
    {

        $this->inventury->init_stock();
    }
    public function store()
    {

        $this->inventury->get_store()->refresh_store(); // this make refresh for store_products



    }

    public function daily()
    {
       
        $this->daily->handle();
        $this->db_create()->db_store();
    }

   
}
