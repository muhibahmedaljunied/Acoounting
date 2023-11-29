<?php

namespace App\Repository\Daily;
use App\RepositoryInterface\DailyRepositoryInterface;
use App\Services\CoreService;
use App\RepositoryInterface\Daily;
use DB;
class PurchaseReturnRepository extends Daily implements DailyRepositoryInterface
{
    public $core;
    public function __construct()
    {

        $this->core = app(CoreService::class);
    }

    public function handle(){

        for ($i = 0; $i < 2; $i++) {

            $this->data_store['count'][$i] = $i;
             if ($i == 0) {
                
                $this->data_store['account_id'][$i] = $this->core->data['store_account'];
                $this->data_store['debit'][$i] = $this->core->data['paid'];
                $this->data_store['credit'][$i] = $this->core->data['remaining'];
            }

            if ($i == 1) {

               $this->payment($i);
            }
        }

    }
    public function payment($i)
    {

        $this->data_store['debit'][$i] = $this->core->data['remaining'];
        $this->data_store['credit'][$i] = $this->core->data['paid'];

        $this->set_acccount($i);
     
      
    }
}
