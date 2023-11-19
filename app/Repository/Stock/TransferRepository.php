<?php

namespace App\Repository\Stock;

use App\Traits\Transfer\TransferTrait;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Services\CoreService;
use DB;

class TransferRepository implements WarehouseRepositoryInterface, DetailRepositoryInterface
{

    public $core;

    use TransferTrait;

    public function __construct()
    {
        $this->core = app(CoreService::class);
    }

    public function add()
    {


      $this->add_into_transfer_table();

    }

    public function init_details(...$list_data)
    {


        $unit_id = (isset($list_data['unit'])) ? $list_data['unit'] 
        : $this->core->data['unit'][$this->core->value];

        $this->add_into_transfer_details_table($unit_id);


    }
}
