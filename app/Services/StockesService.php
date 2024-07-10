<?php

namespace App\Services;

use Illuminate\Http\Request;

use App\RepositoryInterface\WarehouseRepositoryInterface;

use App\Services\PaymentService;

class  StockesService
{

 

    public function __construct(

        public CoreService $core,
        public Request $request,
        public WarehouseRepositoryInterface $warehouse,
        public PaymentService $payment,
    ) {

     
    }

}
