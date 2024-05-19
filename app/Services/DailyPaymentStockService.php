<?php

namespace App\Services;

use App\Models\Bank;
use App\Models\Customer;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\Treasury;

class DailyPaymentStockService
{
    public $core;

    public function __construct()
    {
        $this->core = app(CoreService::class);


    }


    public function get_treasury()
    {
        $this->core->account_details = Treasury::find($this->core->data[$this->core->daily_type]['account_details'][$this->core->row_daily_details]);
    }


    public function get_bank()
    {

        $this->core->account_details = Bank::find($this->core->data[$this->core->daily_type]['account_details'][$this->core->row_daily_details]);
    }
    public function get_supplier()
    {

        $this->core->account_details = Supplier::find($this->core->data[$this->core->daily_type]['account_details'][$this->core->row_daily_details]);
    }


    public function get_customer()
    {

        $this->core->account_details = Customer::find($this->core->data[$this->core->daily_type]['account_details'][$this->core->row_daily_details]);
    }

    public function get_store()
    {

       
        $this->core->account_details = Store::find($this->core->data[$this->core->daily_type]['account_details'][$this->core->row_daily_details]);

    }


    public function check_payment_type()
    {


     
      
        if ($this->core->daily_type == 'debit') {


            $this->debit();
        }


        if ($this->core->daily_type == 'credit') {

            $this->credit();
        }
    }


    public function debit()
    {



        if ($this->core->data['type_daily'] == 'purchase' || $this->core->data['type_daily'] == 'supply') {

            $this->get_store();
        }

        if ($this->core->data['type_daily'] == 'sale' || $this->core->data['type_daily'] == 'cash') {

            $this->choice_account_with_payment();
        }
    }



    public function credit()
    {


        if ($this->core->data['type_daily'] == 'purchase' || $this->core->data['type_daily'] == 'supply') {

            $this->choice_account_with_payment();
        }

        if ($this->core->data['type_daily'] == 'sale' || $this->core->data['type_daily'] == 'cash') {

            $this->get_store();
        }
    }

    public function choice_account_with_payment()
    {



        if ($this->core->data['type_payment'] == 1) {

            $this->get_treasury();
        }

        if ($this->core->data['type_payment'] == 2) {

            if ($this->core->data['type_daily'] == 'sale' || $this->core->data['type_daily'] == 'cash') {
              
                $this->get_customer();

            }

            if ($this->core->data['type_daily'] == 'purchase' || $this->core->data['type_daily'] == 'supply') {
               
                $this->get_supplier();

            }
        }

        if ($this->core->data['type_payment'] == 3) {

            $this->get_bank();
        }
    }
}
