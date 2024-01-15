<?php

namespace App\Repository\Return;
use App\RepositoryInterface\DailyRepositoryInterface;
use App\Services\CoreService;
use App\Traits\DailyTrait;
use DB;

class SaleReturnRepository  implements DailyRepositoryInterface

{

    use DailyTrait;
    public $qty_return_now = 0;
    public $qty_remain = 0;
    public $error;
    public $qty = 0;
    public $core;
    public function __construct()
    {
        $this->core = app(CoreService::class);
    }



    function handle()
    {
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
                $this->data_store['account_id'][$i] = 42;
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
                $this->daily->payment($i);
            }
        }

        // dd($this->daily->data_store);

        // $this->db_create()->db_store();
    }

    public function payment($i)
    {

        $this->data_store['debit'][$i] = $this->core->data['remaining'];
        $this->data_store['credit'][$i] = $this->core->data['paid'];

        $this->set_acccount($i);
        // if ($this->core->data['type_payment'] == 1) {
        //     $this->data_store['account_id'][$i] = $this->core->data['treasury_account'];
        // }
        // if ($this->core->data['type_payment'] == 2) {
        //     $this->data_store['account_id'][$i] = $this->core->data['supplier_account'];
        // }

    }


    public function check_detail()
    {

        $detail = DB::table('sale_return_details')
            ->select('sale_return_details.*')
            ->get();

        return $detail;
    }



}
