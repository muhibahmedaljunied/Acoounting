<?php

namespace App\Repository\Note;
use App\Models\ReceivableNote;
use App\Services\CoreService;
use DB;
class ReceivableBondRepository 
{
    public $core;
    public function __construct()
    {

        $this->core = app(CoreService::class);
    }

    
    public function finish(){


        
        $receivab = new ReceivableNote();
        $receivab->sale_id = $this->core->data['sale_id'];
        $receivab->daily_id = $this->core->daily_id;
        $receivab->date = $this->core->data['date'];
        // $receivab->paid = $this->core->data['paid'];
        $receivab->save();

        

    }
}
