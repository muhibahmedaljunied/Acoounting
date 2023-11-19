<?php

namespace App\Repository\Stock;
use App\RepositoryInterface\DailyRepositoryInterface;
use App\RepositoryInterface\Daily;
use App\Services\CoreService;
use DB;
class SaleReturnRepository extends Daily implements DailyRepositoryInterface
{


    public $core;
    public function __construct()
    {
 
        $this->core = app(CoreService::class);
    }
   
    public function handle(){

        for ($i = 0; $i < 4; $i++) {

            $this->data_store['count'][$i] = $i;
            // $this->daily->data_store['account_id'][$i] = $this->core->data['store_account'];
           
            if ($i == 0) {
                
                $this->data_store['account_id'][$i] = $this->core->data['store_account'];
                $this->data_store['debit'][$i] = $this->core->data['remaining'];
                $this->data_store['credit'][$i] = $this->core->data['paid'];
    
            }

            if ($i == 1) {
                // $this->daily->data_store['account_id'][$i] =$this->get_account_sale_cost();
                $this->data_store['account_id'][$i] =42;
                $this->data_store['debit'][$i] = $this->core->data['paid'];
                $this->data_store['credit'][$i] = $this->core->data['remaining'];


            }

            if ($i == 2) {
                // $this->daily->data_store['account_id'][$i] = $this->get_account_sale();
                $this->data_store['account_id'][$i] = 511;
                $this->data_store['debit'][$i] = $this->core->data['remaining'];
                $this->data_store['credit'][$i] = $this->core->data['paid'];

            }

            if ($i == 3) {
                $this->payment($i);
            }
        }

    }


    public function payment($i)
    {

        $this->data_store['debit'][$i] = $this->core->data['paid'];
        $this->data_store['credit'][$i] = $this->core->data['remaining'];

        $this->set_acccount($i);

   
    }

  


}
