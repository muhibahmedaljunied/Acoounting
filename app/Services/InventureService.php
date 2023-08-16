<?php

namespace App\Services;

use App\Models\PurchaseDetail;
use App\Models\StoreProduct;
use App\RepositoryInterface\StoreProductRepositoryInterface;
use App\Models\Stock;
use DB;

class InventureService
{
    public $core;
    public $SP;

    public function __construct(StoreProductRepositoryInterface $SP)
    {
        $this->core = app(CoreService::class);
        $this->SP = $SP;
    }


    function refresh_stock($type_refresh = null)
    {

        if ($this->core->stock_f != 0) {
            return 0;
        }

        $type = ($type_refresh) ? $type_refresh : $this->core->data['type_refresh'];

        // return $type;
        $stock_f = DB::table('stocks')
            ->where('type_operation', $this->core->data['type'])
            ->where('unit_id', $this->core->data['unit'][$this->core->value][0])
            ->$type('quantity', $this->core->micro_unit_qty);

        $this->core->stock_f = $stock_f;
        return $this;
    }


    function init_stock()
    {

        if ($this->core->stock_f != 0) {
            return 0;
        }
        // dd($this->core->data['unit']);
        $stocks = new Stock();
        $stocks->store_product_id = $this->core->id_store_product;
        $stocks->unit_id = $this->core->unit_value;
        $stocks->type_operation = $this->core->data['type'];
        $stocks->quantity = $this->core->micro_unit_qty;
        $stocks->date = $this->core->data['date'];
        $stocks->save();


        // }
    }

    function get_store($type = null)
    {


        $id_store_product = ($type == 'purchase') ? $this->get_store_product_for_purchase() : $this->get_store_product_for_another();


        $this->core->id_store_product = (count($id_store_product->toarray()) == 0) ? 0 : $id_store_product[0]['id'];

        return $this;
    }


    function init_store()
    {

        if ($this->core->store_product_f != 0) {
            return 0;
        }

        $this->SP->init_store_product();

        return $this;
    }

    function refresh_store(...$list_data)
    {

        $type_refresh = (isset($this->core->data['type_refresh'])) ? $this->core->data['type_refresh'] : $list_data['type_refresh'];
        //    dd($this->SP);
        $this->SP->refresh_store_product(type_refresh: $type_refresh);

        return $this;
    }

    function refresh_price()
    {

        $qty = 0;
        $total = 0;
        $cost = 0;

        $data = PurchaseDetail::where('purchase_details.store_product_id', $this->core->id_store_product)
            ->select('purchase_details.*')
            ->get();

        if (count($data) > 1) {

            foreach ($data as $key => $value) {

                $qty += $value->qty;
                $total += $value->total;
            }

            $cost = $total / $qty;
            // dd($cost);

            DB::table('store_products')->where('store_products.id', $this->core->id_store_product)
                ->update(['cost' => $cost]);
        }
    }

    function get_store_product_for_purchase()
    {


        $id_store_product = StoreProduct::where([
            'product_id' => $this->core->data['product'][$this->core->value],
            'store_id' => $this->core->data['store'],
            'status_id' => $this->core->data['status'][$this->core->value],
            'desc' => $this->core->data['desc'][$this->core->value]
        ])
            ->select()
            ->get();


        return $id_store_product;
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
}
