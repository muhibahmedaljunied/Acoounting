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

        // $this->inventury->refresh_stock('increment')->init_stock();
        $this->init_stock_table();
    }

   




    function init_stock_table()
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
   
}
