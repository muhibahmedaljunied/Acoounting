<?php


namespace App\Repository\StoreInventury;
use App\RepositoryInterface\InventuryStoreRepositoryInterface;
use App\Models\StoreProduct;
use App\Services\CoreService;
class StoreSaleRepository implements InventuryStoreRepositoryInterface
{

    public function __construct(protected CoreService $core)
    {
    }

 

    public function store()
    {

        // $this->get_store_product_table();
        $this->get_store_product_table();
        $this->refresh_store_product_table(); // this make refresh for store_products



    }



    function get_store_product_table($type = null)
    {


        // $id_store_product = ($type == 'purchase') ? $this->get_store_product_for_purchase() : $this->get_store_product_for_another();
        $id_store_product = $this->get_store_product_for_another();


        $this->core->id_store_product = (count($id_store_product->toarray()) == 0) ? 0 : $id_store_product[0]['id'];

        return $this;
    }



    function get_store_product_for_another()
    {

        $id_store_product = StoreProduct::where([
            'store_products.id' => $this->core->data['old'][$this->core->value]['store_product_id'],

        ])
            ->select()
            ->get();

        return $id_store_product;
    }


 
   
    public function refresh_store_product_table(...$list_data)
    {

        $this->core->store_product_f =  DB::table('store_products')
            ->where(['id' => $this->core->id_store_product])
            ->decrement('quantity', $this->core->micro_unit_qty);
    }







        // function get_store_product_for_purchase()
    // {


    //     $id_store_product = StoreProduct::where([
    //         'product_id' => $this->core->data['product'][$this->core->value],
    //         'store_id' => $this->core->data['store'],
    //         'status_id' => $this->core->data['status'][$this->core->value],
    //         'desc' => $this->core->data['desc'][$this->core->value]
    //     ])
    //         ->select()
    //         ->get();


    //     return $id_store_product;
    // }


}