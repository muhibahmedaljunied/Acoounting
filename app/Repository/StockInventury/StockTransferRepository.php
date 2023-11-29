<?php

namespace App\Repository\StockInventury;
use App\RepositoryInterface\InventuryStockRepositoryInterface;
use App\Services\CoreService;
use App\Models\Stock;
class StockTransferRepository implements InventuryStockRepositoryInterface
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
        $stocks->store_product_id = $this->core->data_store_product['store_product_id'];
        $stocks->unit_id = $this->core->unit_value;
        $stocks->quantity = $this->core->micro_unit_qty;
        $stocks->date = $this->core->data['date'];
        $stocks->stockable()->associate($this->core->transfer);
        $stocks->save();


    }
   
}
