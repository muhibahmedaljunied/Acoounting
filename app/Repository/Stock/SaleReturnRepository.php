<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\Purchase\PurchaseTrait;
use App\Services\CoreService;
use DB;

class SaleReturnRepository  implements WarehouseRepositoryInterface, 
DetailRepositoryInterface,
DetailRefreshRepositoryInterface
{

use PurchaseTrait;

    public $core;
    public function __construct()
    {

      
        $this->core = app(CoreService::class);
    }

    public function add()
    {


        $this->add_into_sale_return_table($this->core);
     

    }

    public function init_details(...$list_data)
    {

        $this->add_into_sale_return_details_table($this->core);
  
    }

        function refresh_details()
    {



        DB::table('sale_details')
            ->where(['store_product_id' => $this->core->data['old'][$this->core->value]['store_product_id']])
            ->increment('qty_return', $this->core->data['old'][$this->core->value]['qty_return_now']);
        // dd($result);



    }

   

   
}
