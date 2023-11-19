<?php


namespace App\Repository\StoreInventury;

use App\RepositoryInterface\InventuryStoreRepositoryInterface;
use App\Traits\Sale\StoreProductTrait;
use App\Services\CoreService;
class StoreSaleRepository implements InventuryStoreRepositoryInterface
{

    use StoreProductTrait;
    public function __construct(protected CoreService $core)
    {
    }



    public function store()
    {


        $this->get_store_product();
        $this->refresh_store_product_table(); // this make refresh for store_products



    }


    function get_store_product()
    {

     

        $id_store_product = $this->get_store_product_table();

        $this->core->id_store_product = (count($id_store_product->toarray()) == 0) ? 0 : $id_store_product[0]['id'];
    }



}
