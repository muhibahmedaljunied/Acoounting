<?php

namespace App\Services;


use App\Services\InventureService;
use App\Traits\Temporale\TemporaleTrait;
use App\Services\CoreService;
use Illuminate\Http\Request;
use DB;

class TransferService
{
    use TemporaleTrait;
    public $request;
    public $sale_id = 0;
    public $temporale = 0;
    public $discount;
    public $core;
    public function __construct(
        protected InventureService $inventury,


    ) {


        $this->core = app(CoreService::class);
        $this->core->store_product_f = 0;
        $this->core->stock_f = 0;
    }





    public function Stock()
    {

        // $this->inventury->refresh_stock('increment')->init_stock();
        $this->inventury->init_stock();
    }
    public function store()
    {

        $this->inventury->get_store()->refresh_store(type_refresh:'decrement')
            ->refresh_store(type_refresh:'increment')
            ->init_store();
    }
}
