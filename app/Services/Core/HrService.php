<?php

namespace App\Services\Core;
use App\RepositoryInterface\HRRepositoryInterface;
use App\Services\CoreStaffService;
class HrService
{

    public function __construct(
        protected HRRepositoryInterface $hr,
        protected CoreStaffService $core
        )
    {
        

    }



    public function store()
    {


        $this->refresh();
        $this->init();
    }


    public function refresh()
    {


        $this->core->temporale_f = $this->hr->update();
    }



    public function init()
    {


        if ($this->core->temporale_f->isEmpty()) {

            $this->hr->add();
        }
    }
}
