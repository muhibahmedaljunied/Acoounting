<?php

namespace App\Repository\StoreInventury;
use App\RepositoryInterface\InventuryStoreRepositoryInterface;
use App\Services\CoreService;
use App\Models\StoreProduct;
class StoreTransferRepository implements InventuryStoreRepositoryInterface
{

    public function __construct(protected CoreService $core)
    {
    }
    public function get()
    {

        // $this->get_store_product_table();
        // $this->refresh_store_product_table(type_refresh:'decrement');
        // $this->refresh_store_product_table(type_refresh:'increment');
        // $this->init_store_product_table();
    }

    public function store()
    {

        // $this->get_store_product_table();
        $this->get_store_product_table();
        $this->refresh_store_product_table(type_refresh:'decrement');
        $this->refresh_store_product_table(type_refresh:'increment');
        $this->init_store_product_table();
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

    public function init_store_product_table()
    {

        // dd($this->core->data['old']);
        $store_product = new StoreProduct();
        $store_product->product_id = $this->core->data['old'][$this->core->value]['product_id'];
        $store_product->store_id = $this->core->data['into_store'];
        $store_product->status_id = $this->core->data['old'][$this->core->value]['status_id'];
        $store_product->desc = $this->core->data['old'][$this->core->value]['desc'];
        $store_product->quantity = $this->core->micro_unit_qty;
        $store_product->cost = $this->core->data['old'][$this->core->value]['cost'];
        $store_product->save();
        $this->core->id_store_product = $store_product->id;
    }
 

    public function refresh_store_product_table(...$list_data)
    {

        // $store_id = (isset($list_data['store_id'])) ? $list_data['store_id'] : $this->core->data['store'][$this->core->value];

        $type_refresh = $list_data['type_refresh'];
        // dd($type_refresh);
        // $store_id = $list_data['store_id'];
        if ($type_refresh == 'decrement') {
            
            $this->core->store_product_f =  DB::table('store_products')
            ->where(['id' => $this->core->id_store_product])
            ->decrement('quantity', $this->core->micro_unit_qty);
           
        }
        if ($type_refresh == 'increment') {

            $this->core->store_product_f =  DB::table('store_products')
            ->where(['store_id' => $this->core->data['intostore_id']])
            ->increment('quantity', $this->core->micro_unit_qty);
        }
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
