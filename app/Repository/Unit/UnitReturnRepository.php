<?php

namespace App\Repository\Unit;
use App\Services\CoreService;
class UnitReturnRepository 
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


        if ($this->core->unit_array[2] == 1) {  //this means unit_type

            $this->core->micro_unit_qty = $this->core->data['old'][$this->core->value]['qty_return_now'] * $this->core->unit_array[1];
        } else {
            $this->core->micro_unit_qty = $this->core->data['old'][$this->core->value]['qty_return_now'];
        }
        return $this;
    }




    
 
}
