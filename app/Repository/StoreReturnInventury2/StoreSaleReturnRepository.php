<?php


namespace App\Repository\StoreReturnInventury;
class StoreSaleReturnRepository extends StoreReturnRepository
{

  

    public function store()
    {

        $this->get_store_product();
        $this->refresh_store_product_table(); // this make refresh for store_products
        // $this->refresh_store_product();

    }



 


    // public function refresh_store_product_table(...$list_data)
    // {

    //     $this->core->store_product_f =  DB::table('store_products')
    //         ->where(['id' => $this->core->id_store_product])
    //         ->increment('quantity', $this->core->micro_unit_qty);
    // }



    // function get_store_product()
    // {

    //     $id_store_product =  StoreProduct::where([
    //         'store_products.id' => $this->core->data['old'][$this->core->value]['store_product_id'],

    //     ])
    //         ->select()
    //         ->get();

    //     $this->core->id_store_product = (count($id_store_product->toarray()) == 0) ? 0 : $id_store_product[0]['id'];

    //     return $this;
    // }
}
