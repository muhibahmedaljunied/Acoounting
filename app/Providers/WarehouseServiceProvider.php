<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\Repository\Stock\PurchaseReturnRepository;
use App\Repository\Stock\SaleReturnRepository;
use App\Repository\Stock\PurchaseRepository;
use App\Repository\Stock\SaleRepository;
use App\Repository\Stock\TransferRepository;
class WarehouseServiceProvider extends ServiceProvider
{

    public function register()
    {

        

        $this->app->bind(WarehouseRepositoryInterface::class, function () {

            $request = app(\Illuminate\Http\Request::class);

            if ($request->type == 'Purchase') {

                return new PurchaseRepository();
            }

            if ($request->type == 'Sale') {

                return new SaleRepository();
            }

            if ($request->type == 'PurchaseReturn') {

                return new PurchaseReturnRepository();
            }

            if ($request->type == 'SaleReturn') {

                return new SaleReturnRepository();
            }



            if ($request->type == 'Transfer') {

                return new TransferRepository();
            }


            // return new PurchaseRepository();
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
     
    }
}
