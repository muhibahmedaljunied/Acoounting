<?php


namespace App\Repository\StoreInventury;

use App\RepositoryInterface\InventuryStoreRepositoryInterface;
use App\Traits\Purchase\StoreProductTrait;
use App\Services\CoreService;
use Illuminate\Support\Facades\DB;
class StorePurchaseRepository implements InventuryStoreRepositoryInterface
{

    use StoreProductTrait;
    public function __construct(protected CoreService $core)
    {
    }

    public function store()
    {
        $this->get_store_product();
        $this->refresh_store_product();
        $this->init_store_product(); // this make refresh for store_products

    }


    function get_store_product()
    {

        $id_store_product = $this->get_store_product_table();

        $this->core->id_store_product = (count($id_store_product->toarray()) == 0) ? 0 : $id_store_product[0]['id'];
    }


    public function init_store_product()
    {


        if ($this->core->store_product_f != 0) {
            return 0;
        }
        $this->core->id_store_product = $this->init_store_product_table();
    }

    public function refresh_store_product(...$list_data)
    {


        $this->core->store_product_f = $this->refresh_store_product_table();
    }
}
