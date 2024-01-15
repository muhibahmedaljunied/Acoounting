<?php

namespace App\Providers;
use App\RepositoryInterface\UnitRepositoryInterface;
use App\Repository\Unit\UnitTransferRepository;
use App\Repository\Unit\UnitCashRepository;
use App\Repository\Unit\UnitSupplyRepository;
use App\Repository\Unit\UnitReturnRepository;
use App\Repository\Unit\UnitSaleRepository;
use App\Repository\Unit\UnitPurchaseRepository;

use Illuminate\Support\ServiceProvider;

class UnitServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(UnitRepositoryInterface::class, function () {

            $request = app(\Illuminate\Http\Request::class);


            if ($request->type == 'Purchase') {

                return new UnitPurchaseRepository();
            }

            if ($request->type == 'Sale') {

                return new UnitSaleRepository();
            }

            if ($request->type == 'Cash') {

                return new UnitCashRepository();
            }

            if ($request->type == 'Supply') {

                return new UnitSupplyRepository();
            }

        

            // if ($request->type == 'PurchaseReturn' || $request->type == 'SaleReturn') {

            //     return new UnitReturnRepository();
            // }


            if ($request->type == 'Transfer') {

                return new UnitTransferRepository();
            }
            return new UnitReturnRepository();
          




        });

     

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
