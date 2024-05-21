<?php

namespace App\Services;
use App\RepositoryInterface\UnitRepositoryInterface;
class UnitService
{

    public function __construct(
    
        protected UnitRepositoryInterface $unit,


    ) {
  
     
        
    }


    public function unit_and_qty()
    {

        // this make decode for unit and convert qty into miqro
        $this->unit->decode_unit();
        $this->unit->convert_qty();

    }



    
}
