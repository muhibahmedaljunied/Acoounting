<?php

namespace App\Traits\Transfer;

use App\Models\Transfer;
use App\Models\TransferDetail;

trait TransferTrait
{

    public function add_into_transfer_table()
    {

        $table_one = new Transfer();
        $table_one->date =  $this->core->data['date'];
        $table_one->save();
        $this->core->transfer_id = $table_one->id;
        $this->core->transfer = $table_one;

    }

    public function add_into_transfer_details_table($unit_id)
    {
  
        
        // dd($this->core->data['fromstore']);
        $details = new TransferDetail();
        $details->transfer_id = $this->core->transfer_id;
        $details->from_store = $this->core->data['fromstore'];
        $details->into_store = $this->core->data['intostore'];
        $details->store_product_id = $this->core->id_store_product;
        $details->unit_id = $unit_id[0];
        $details->qty = $this->core->micro_unit_qty;
        $details->save();

        // dd($details);
    


    }
}
