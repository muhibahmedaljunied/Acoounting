<?php

namespace App\Repository\Unit;
use App\RepositoryInterface\UnitRepositoryInterface;
use App\Services\CoreService;
class UnitTransferRepository implements UnitRepositoryInterface
{


    public $core;
    public function __construct()
    {
        $this->core = app(CoreService::class);
    }

    public function decode_unit()
    {

        $this->core->unit_array = $this->core->data['unit'][$this->core->value];
        $this->core->unit_value = $this->core->unit_array[0];
        return $this;

    }



    function convert_qty()
    {


        if ($this->core->unit_array[2] == 0) {  //this means unit_type

            $micro_unit_qty = $this->core->data['qty_transfer'][$this->core->value];
        } else {

            $micro_unit_qty = $this->core->data['qty_transfer'][$this->core->value] * $this->core->unit_array[1];
        }
        $this->core->micro_unit_qty = $micro_unit_qty;
        return $this;
    }



    
 
}
