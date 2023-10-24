<?php

namespace App\Traits\Warehouse;

use App\Models\Transfer;
use App\Models\TransferDetail;

trait TransferTrait
{

    public function add_into_transfer_table()
    {

        $table_one = new Transfer();
        $table_one->date =  $this->core->data['date'];
        $table_one->save();

        return $table_one->id;
    }

    public function add_into_transfer_details_table()
    {
        $Details = new TransferDetail();
        $Details->purchase_id = $this->core->purchase_id;
        $Details->price = $this->core->data['price'][$this->core->value];
        $Details->qty = $this->core->data['qty'][$this->core->value];
        $Details->total = $this->core->data['sub_total'];
        $Details->store_product_id = $this->core->id_store_product;
        $Details->unit_id = $this->core->unit_value;
        $Details->qty = $this->core->data['qty'][$this->core->value];
        $Details->save();
    }
}
