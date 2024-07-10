<?php

namespace App\Repository\StockInventury;

use App\Services\CoreService;
use App\Models\Stock;

 class StockRepository
{


    public function __construct(protected CoreService $core)
    {
    }

    // abstract function Stock();
    

    // function refresh_stock_table($type_refresh = null)
    // {

    //     if ($this->core->stock_f != 0) {
    //         return 0;
    //     }

    //     $type = ($type_refresh) ? $type_refresh : $this->core->data['type_refresh'];

    //     // return $type;
    //     $stock_f = DB::table('stocks')
    //         ->where('type_operation', $this->core->data['type'])
    //         ->where('unit_id', $this->core->unit_array[0])
    //         ->$type('quantity', $this->core->micro_unit_qty);
    //         // ->$type('quantity', $this->core->data['qty'][$this->core->value]);


    //     $this->core->stock_f = $stock_f;
    //     return $this;
    // }

    function stock()
    {

        if ($this->core->stock_f != 0) {
            return 0;
        }

        // dd($this->core->data['unit']);
        $stocks = new Stock();
        $stocks->store_product_id = $this->core->id_store_product;
        // $stocks->unit_id = $this->core->unit_value;
        $stocks->unit_id = $this->core->unit_array[0];

        $stocks->quantity = $this->core->micro_unit_qty;
        // $stocks->quantity = $this->core->data['qty'][$this->core->value];
        $stocks->date = $this->core->data['date'];
        $stocks->stockable()->associate($this->core->stockable); //$this->core->purchase === $this->core->stockable
        $stocks->save();


        // }
    }


}
