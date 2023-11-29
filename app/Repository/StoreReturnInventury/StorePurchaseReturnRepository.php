<?php


namespace App\Repository\StoreReturnInventury;

use App\RepositoryInterface\InventuryStoreRepositoryInterface;
use App\Traits\Purchase\StoreProductTrait;
use App\Models\StoreProduct;
use App\Services\CoreService;
use Illuminate\Support\Facades\DB;
class StorePurchaseReturnRepository implements InventuryStoreRepositoryInterface
{

    use StoreProductTrait;

    public function __construct(protected CoreService $core)
    {
    }


    public function store()
    {
        $this->get_store_product();
        $this->refresh_store_product();
    }


    function get_store_product($type = null)
    {



        $id_store_product = $this->get_store_product_for_another();

        $this->core->id_store_product = (count($id_store_product->toarray()) == 0) ? 0 : $id_store_product[0]['id'];

        return $this;
    }

    public function refresh_store_product()
    {

        $this->core->store_product_f =  DB::table('store_products')
            ->where(['id' => $this->core->id_store_product])
            ->decrement('quantity', $this->core->micro_unit_qty);

    }


    function get_store_product_for_another()
    {

        return StoreProduct::where([
            'store_products.id' => $this->core->data['old'][$this->core->value]['store_product_id'],

        ])
            ->select()
            ->get();

       
    }



}
