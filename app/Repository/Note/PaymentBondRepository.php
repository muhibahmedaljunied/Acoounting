<?php

namespace App\Repository\Note;
use App\Models\PayableNote;
use App\Services\CoreService;
use DB;
class PaymentBondRepository 
{
    public $core;
    public function __construct()
    {

        $this->core = app(CoreService::class);
    }

    public function finish(){

        $data = new PayableNote();
        $data->purchase_id = $this->core->data['id'];
        $data->daily_id = $this->core->daily_id;
        $data->date = $this->core->data['date'];
        // $data->paid = $this->core->data['paid'];
        $data->save();


    }

}
