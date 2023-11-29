<?php

namespace App\Repository\StoreInventury;

use App\RepositoryInterface\InventuryStoreRepositoryInterface;
use App\Traits\Transfer\StoreProductTrait;
use App\Services\CoreService;


class StoreTransferRepository implements InventuryStoreRepositoryInterface
{

    use StoreProductTrait;
    public function __construct(protected CoreService $core)
    {
    }


    public function store()
    {

        $this->get_store_product();
        $this->refresh_store_product_table();
        $this->init_store_product_table();
    }




    function get_store_product()
    {

        $id_store_product = $this->get_store_product_table();

        $this->core->data_store_product = (count($id_store_product->toarray()) == 0) ? 0
        :
        [
            'store_product_id' => $id_store_product[0]['id'],
            'product_id' => $id_store_product[0]['product_id'],
            'status_id' => $id_store_product[0]['status_id'],
            'desc' => $id_store_product[0]['desc']
        ];

      

    }




    public function refresh_store_product_table()
    {

        $this->decrement_store_product_tale();
        $this->increment_store_product_table();
    }
}
