<?php

namespace App\Repository\Unit;

use App\RepositoryInterface\UnitRepositoryInterface;
use App\Services\CoreService;

class UnitPurchaseRepository implements UnitRepositoryInterface
{


    public $core;
    public function __construct()
    {
        $this->core = app(CoreService::class);
    }

    public function decode_unit()
    {



        // dd(json_decode($this->core->data['unit'][$this->core->value]));
        $this->core->unit_array = json_decode($this->core->data['unit'][$this->core->value]);
        // dd(1);
        // $this->core->unit_value = $this->core->unit_array[0];
        // $this->core->unit_value = $this->core->unit_array;

        return $this;
    }

    function convert_qty()
    {


      
        foreach ($this->core->data['units'] as  $value) {


            if ($value['unit_id'] == $this->core->unit_array[0]) {  //this means unit_type

                $this->core->micro_unit_qty = ($this->core->data['qty'][$this->core->value] * $value['rate']);

            }
    
        }

        return $this;
    }
}
