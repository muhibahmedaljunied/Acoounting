<?php

namespace App\Services;

class CoreDailyService
{
    public $status_daily_detail = [];
    public $dailyDetailId_item = [];
    public $dailyId;
    public $daily_type;
    public $dailyDetailId;
    public $account_id;
    public $account_details;
    // public $value;
    public $row_daily_details;


    public function set_row_daily_details($value)
    {

        $this->row_daily_details = $value;
    }

    public function set_account_details($value)
    {

        $this->row_daily_details = $value;
    }


    public function set_account_id($value)
    {

        $this->account_id = $value;
    }


    public function set_dailyDetailId($value)
    {

        $this->dailyDetailId = $value;
    }


    public function set_daily_type($value)
    {

        $this->daily_type = $value;
    }


    public function set_dailyId($value)
    {

        $this->dailyId = $value;
    }

    public function set_dailyDetailId_item($value)
    {

        $this->dailyDetailId_item = $value;
    }

    public function set_status_daily_detail($value)
    {

        $this->status_daily_detail = $value;
    }
  

}
