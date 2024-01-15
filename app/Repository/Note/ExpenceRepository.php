<?php

namespace App\Repository\Note;
use App\Models\Expence;
use App\Services\CoreService;
use DB;
class ExpenceRepository 
{
    public $core;
    public function __construct()
    {

        $this->core = app(CoreService::class);
    }

    public function finish(){


                
        $expence = new Expence();
        $expence->date =  $this->core->data['date'];
        $expence->daily_id =  $this->core->daily_id;
        $expence->save();


    }

}
