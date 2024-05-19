<?php

namespace App\Services;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\DailyTrait;
class ReturnService
{

    // use DailyTrait;
    public function __construct(
        protected DetailRepositoryInterface $details,
        protected DetailRefreshRepositoryInterface $refresh,
 


    ) {

    }



    public function details()
    {


        $this->details->init_details(); // this make initial for details tables
      

        $this->refresh->refresh_details();  //this hadle data in details table
   
    }

   



   
}
