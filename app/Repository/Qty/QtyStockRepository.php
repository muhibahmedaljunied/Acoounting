<?php

namespace App\Repository\Qty;
use App\Traits\Unit\UnitsTrait;

class QtyStockRepository
{


    use UnitsTrait;
    public $r;
    public $qty;
    public $value;
    public $details;
    public $compare_array;



    public function handle_qty()
    {




        // dd($this->details);
        foreach ($this->details as $value) {


            // $this->value = collect($value)->toArray();
            $this->value = $value;
            $this->units();
            $this->init_qty();
            $this->translate_qty();
        }
    }

    

    public function init_qty()
    {



        foreach ($this->compare_array  as $value0) {
            
            // dd($this->value);

                $this->qty[$value0] = collect($this->value)->toArray()[$value0];
                $this->r[$value0] = array();
            

        }

     

       
    }

    function translate_qty()
    {

        foreach ($this->compare_array as $value0) {

            foreach ($this->value->units as $key => $value) {



                if ($this->qty[$value0] / $value->rate >= 1) {


                    $this->r[$value0]["$key"] = array(

                        [
                            intval($this->qty[$value0] / $value->rate),

                            $value->name
                        ]


                    );
                }

                if ($this->qty[$value0] % $value->rate >= 1) {

                    $this->qty[$value0] = $this->qty[$value0] % $value->rate;
                } else {

                    break;
                }
            }

            // $this->value->qty_after_convert = $this->r[$value0];
            
        }
   

        // dd($this->r);
        $this->value->qty_after_convert = $this->r;
        
    }



    

}
