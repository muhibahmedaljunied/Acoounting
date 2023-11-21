<?php


namespace App\Repository\Inventury\StoreInventury;
use App\RepositoryInterface\InventuryStoreRepositoryInterface;
use App\Models\StoreProduct;
use App\Services\CoreService;

class StoreSaleReturnRepository implements InventuryStoreRepositoryInterface
{
    
    public function __construct(protected CoreService $core)
    {
    }

    public function store()
    {

        $this->get_store_product_table();
        $this->refresh_store_product_table(); // this make refresh for store_products

    }



    function get_store_product_table($type = null)
    {

        $id_store_product = $this->get_store_product_for_another();

        $this->core->id_store_product = (count($id_store_product->toarray()) == 0) ? 0 : $id_store_product[0]['id'];

        return $this;
    }


    public function refresh_store_product_table(...$list_data)
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
