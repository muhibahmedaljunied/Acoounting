<?php

namespace App\Services;

use App\RepositoryInterface\HRRepositoryInterface;

class CoreStaffService
{
    public $data;
    public $id;
    public $value;
    public $temporale_f;
    public $status_sanction = false;

    public function setValue($value){

        $this->value = $value;
    }

    
    public function setData($data){

        $this->data = $data;
    }
   

   
}
