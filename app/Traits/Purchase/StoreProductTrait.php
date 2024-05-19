<?php

namespace App\Traits\Purchase;
use App\Models\StoreProduct;
use Illuminate\Support\Facades\DB;

trait StoreProductTrait
{


    function get_store_product_table()
    {


        // dd($this->core->data);
        return StoreProduct::where([
            'product_id' => $this->core->data['product'][$this->core->value],
            'store_id' => $this->core->data['store'],
            'status_id' => $this->core->data['status'][$this->core->value],
            'desc' => $this->core->data['desc'][$this->core->value]
        ])
            ->select()
            ->get();

    }




    public function init_store_product_table()
    {


        $store_product = new StoreProduct();
        $store_product->product_id = $this->core->data['product'][$this->core->value];
        $store_product->store_id = $this->core->data['store'];
        $store_product->status_id = $this->core->data['status'][$this->core->value];
        $store_product->desc = $this->core->data['desc'][$this->core->value];
        $store_product->quantity = $this->core->micro_unit_qty;
        $store_product->cost = $this->core->data['price'][$this->core->value];
        $store_product->save();
        return $store_product->id;
    }

    public function refresh_store_product_table(...$list_data)
    {

        return  DB::table('store_products')
            ->where(['id' => $this->core->id_store_product])
            ->increment('quantity', $this->core->micro_unit_qty);
    }


}
