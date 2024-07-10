<?php

namespace App\Services;

use App\Repository\Unit\QtyRepository;
use App\Traits\Unit\UnitsTrait;
use Illuminate\Http\Request;

class UnitService
{

    use UnitsTrait;

    public $core;
    public $value;
    public $unit;
    public $units;
    public $quantity = 0;
    public $qty_available = 0;
    public $qty = 0;
    public $r_qty;
    public $r_qty_available;
    public $r_quantity;
    public $key;




    public function __construct(QtyRepository $qty)
    {

        $this->qty = $qty;
    }

    public function handle_qty($details)
    {




        foreach ($details as $value) {



            $this->value = $value;
            $this->units();
            $this->init_qty(['qty','quntity','qty_available']);
            $this->translate_qty();
    
        }
    }

    
    public function init_qty($array_qty)
    {

        foreach ($array_qty as $key => $value) {



            if ($value == 'qty') {


                $this->qty = $this->value->qty;
                $this->r_qty = array();
            }


            if ($value = 'quantity') {


                $this->quantity = $this->value->quantity;
                $this->r_quantity = array();
            }



            if ($value = 'qty_available') {


                $this->qty_available = $this->value->qty_available;
                $this->r_qty_available = array();
            }
        }
    }

    function translate_qty()
    {

        foreach ($this->units as $key2 => $value2) {



            if ($this->quantity / $value2->rate >= 1) {


                $this->r_qty["$key2"] = array(

                    [
                        intval($this->quantity / $value2->rate),

                        $value2->name
                    ]


                );
            }

            if ($this->quantity % $value2->rate >= 1) {

                $this->quantity = $this->quantity % $value2->rate;
            } else {

                break;
            }
        }

        $this->value->qty_after_convert = $this->r_qty;
    }


}
