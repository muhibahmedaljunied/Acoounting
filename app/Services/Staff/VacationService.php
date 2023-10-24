<?php

namespace App\Services;
use App\Services\Core\SanctionService;

class VacationService extends SanctionService
{
   


    public function store(){
        

        $this->refresh();
        $this->init();

       
       

    }



   
}
