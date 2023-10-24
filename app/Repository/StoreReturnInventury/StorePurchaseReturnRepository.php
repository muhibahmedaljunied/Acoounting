<?php


namespace App\Repository\Inventury\StoreInventury;

use App\RepositoryInterface\InventuryStoreRepositoryInterface;
use App\Models\StoreProduct;
use App\Services\CoreService;

class StorePurchaseReturnRepository implements InventuryStoreRepositoryInterface
{


    public function __construct(protected CoreService $core)
    {
    }


    public function store()
    {
        $this->get_store_product_table();
        $this->refresh_store_product_table();
    }


    function get_store_product_table($type = null)
    {


        // $id_store_product = ($type == 'purchase') ? $this->get_store_product_for_purchase() : $this->get_store_product_for_another();

        $id_store_product = $this->get_store_product_for_another();

        $this->core->id_store_product = (count($id_store_product->toarray()) == 0) ? 0 : $id_store_product[0]['id'];

        return $this;
    }

    public function refresh_store_product_table(...$list_data)
    {


        $this->core->store_product_f =  DB::table('store_products')
            ->where(['id' => $this->core->id_store_product])
            ->increment('quantity', $this->core->micro_unit_qty);
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







    // public function init_store_product_table()
    // {


    //          if ($this->core->store_product_f != 0) {
    //         return 0;
    //     }

    //     $store_product = new StoreProduct();
    //     $store_product->product_id = $this->core->data['product'][$this->core->value];
    //     $store_product->store_id = $this->core->data['store'][$this->core->value];
    //     $store_product->status_id = $this->core->data['status'][$this->core->value];
    //     $store_product->desc = $this->core->data['desc'][$this->core->value];
    //     $store_product->quantity = $this->core->micro_unit_qty;
    //     $store_product->cost = $this->core->data['price'][$this->core->value];
    //     $store_product->save();
    //     // dd($store_product->id); 
    //     $this->core->id_store_product = $store_product->id;
    // }





}
