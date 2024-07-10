<?php

namespace App\Repository\StockInventury;

use App\Models\Stock;
use App\Services\CoreService;

class StockTransferRepository extends StockRepository
{
    public function __construct(protected CoreService $core)
    {
    }

 
    public function Stock()
    {

        $this->init_stock_table();
    }



    function init_stock_table()
    {

        if ($this->core->stock_f != 0) {
            return 0;
        }

 
        $stocks = new Stock();
        $stocks->store_product_id = $this->core->data_store_product[0]['id'];
        // $stocks->unit_id = $this->core->unit_array[0];
        $stocks->quantity = $this->core->micro_unit_qty;
        $stocks->date = $this->core->data['date'];
        $stocks->stockable()->associate($this->core->stockable);//$this->core->transfer === $this->core->stockable
        $stocks->save();


    }
   
}
