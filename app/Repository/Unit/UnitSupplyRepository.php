<?php

namespace App\Repository\Unit;
use App\RepositoryInterface\UnitRepositoryInterface;
use App\Services\CoreService;
class UnitSupplyRepository implements UnitRepositoryInterface
{


    public $core;
    public function __construct()
    {
        $this->core = app(CoreService::class);
    }

   public function decode_unit()
    {

      
        $this->core->unit_array = json_decode($this->core->data['unit'][$this->core->value]);
        $this->core->unit_value = $this->core->unit_array[0];

        return $this;

    }

    function convert_qty()
    {


        if ($this->core->unit_array[2] == 1) {  //this means unit_type

            $this->core->micro_unit_qty = $this->core->data['qty'][$this->core->value] * $this->core->unit_array[1];
        } else {
            $this->core->micro_unit_qty = $this->core->data['qty'][$this->core->value];
        }
        return $this;
    }



    
 
}
