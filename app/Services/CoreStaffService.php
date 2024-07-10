<?php

namespace App\Services;

use App\RepositoryInterface\HRRepositoryInterface;

class CoreStaffService
{
    public $data;
    public $data_sanction;
    public $id;
    public $value;
    public $temporale_f;
    public $status_sanction = false;
    public $specific_sanction;
    public $data_of_hr_for_update_payroll;

    // ---------------------
    public $debit = [];
    public $credit = [];
    public $paid =[];
    public $hr_account_id = [];
    // ---------------------


    public function setValue($value)
    {

        $this->value = $value;
    }


    public function setData($data)
    {

        $this->data = $data;
    }
}
