<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Models\SupplyReturn;
use App\Models\CashReturn;
use App\Models\SaleReturn;
use App\Models\PurchaseReturn;
use Illuminate\Http\Request;
use DB;

class Returns extends Facade
{

     /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'return';
    }

    
}
