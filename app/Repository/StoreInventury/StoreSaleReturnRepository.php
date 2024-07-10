<?php


namespace App\Repository\StoreInventury;

use App\Models\StoreProduct;
use App\RepositoryInterface\StoreRepositoryInterface;
use App\Services\CoreService;

class StoreSaleReturnRepository extends StoreRepository implements StoreRepositoryInterface
{

    public $operation;

    public function __construct(CoreService $core)
    {
        $this->core = $core;
        $this->operation = 'increment';
    }
    public function store()
    {


        $this->get_store_product_first();
        $this->check_founded_store();
    }

    public function check_founded_store()
    {


        if ($this->core->id_store_product == 0) {


            $this->init_store_product_table();

        } else {


            $this->refresh_store_product();
        }



    }

    public function refresh_store_product()
    {



            $this->refresh_qty_store_product_table();
            $this->refresh_total_store_product_table();
            $this->get_store_product_first();
            $this->refresh_cost_store_product_table();
    }


    public function init_store_product_table()
    {



        $this->core->data_store_product = new StoreProduct();
        $this->core->data_store_product->product_id = $this->core->data['old'][$this->core->value]['product_id'];
        $this->core->data_store_product->store_id = $this->core->data['store'][$this->core->value];
        $this->core->data_store_product->status_id = $this->core->data['old'][$this->core->value]['status_id'];
        $this->core->data_store_product->desc = $this->core->data['old'][$this->core->value]['desc'];
        $this->core->data_store_product->quantity = $this->core->micro_unit_qty;
        $this->core->data_store_product->cost = $this->core->data['total'][$this->core->value] / $this->core->micro_unit_qty;
        $this->core->data_store_product->total = $this->core->data['total'][$this->core->value];
        $this->core->data_store_product->save();
        $this->core->id_store_product =  $this->core->data_store_product->id;
    }
}
