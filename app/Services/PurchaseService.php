<?php

namespace App\Services;

use App\Services\InventureService;
use App\Repository\Stock\PurchaseRepository;
use App\Traits\DailyTrait;

class PurchaseService
{

    use DailyTrait;
    public $discount;
    public $core;
    public $message;
    public $status_request = 'faild';
    public $id;

    public function __construct(
        protected InventureService $inventury,
        protected PurchaseRepository $daily

    ) {
        $this->core = app(CoreService::class);
        $this->core->store_product_f = 0;
        $this->core->stock_f = 0;
    }

    public function Stock()
    {

        $this->inventury->refresh_price(); //this make refresh for cost of product

        $this->inventury->init_stock();
    }
    public function store()
    {



        $this->inventury->get_store('purchase')->refresh_store()->init_store(); // this make refresh for store_products



    }



    public function daily()
    {


        $this->daily->handle();
        $this->db_create()->db_store();
    }
}
