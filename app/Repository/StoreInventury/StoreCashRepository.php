<?php


namespace App\Repository\StoreInventury;
use App\Traits\Cash\StoreProductTrait;
class StoreCashRepository extends StoreRepository
{

    use StoreProductTrait;
    public function store()
    {


        $this->get_store_product();
        $this->refresh_store_product(); // this make refresh for store_products



    }


    function get_store_product()
    {

     

        $id_store_product = $this->get_store_product_table();

        $this->core->id_store_product = (count($id_store_product->toarray()) == 0) ? 0 : $id_store_product[0]['id'];
    }

    public function refresh_store_product(...$list_data)
    {


        $this->core->store_product_f = $this->refresh_store_product_table();
    }



}
