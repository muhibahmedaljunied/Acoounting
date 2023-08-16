<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\RepositoryInterface\StockRepositoryInterface;
use App\RepositoryInterface\StoreProductRepositoryInterface;
use App\Repository\Return\PurchaseReturnRepository;
use App\Repository\Return\SaleReturnRepository;
use App\Repository\Stock\PurchaseRepository;
use App\Repository\Stock\SaleRepository;
use App\Repository\Stock\SupplyRepository;
use App\Repository\Stock\CashRepository;
use App\Repository\Stock\TransferRepository;

class StockServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        


        $this->app->bind(StoreProductRepositoryInterface::class, function () {

            $request = app(\Illuminate\Http\Request::class);

            if ($request->type == 'Purchase') {

                return new PurchaseRepository();
            }

            if ($request->type == 'Sale') {

                return new SaleRepository();
            }

            if ($request->type == 'Supply') {

                return new SupplyRepository();
            }


            if ($request->type == 'Cash') {

                return new CashRepository();
            }
            if ($request->type == 'Transfer') {

                return new TransferRepository();
            }

            if ($request->type == 'PurchaseReturn') {

                return new PurchaseReturnRepository();
            }

            if ($request->type == 'SaleReturn') {

                return new SaleReturnRepository();
            }


            return new PurchaseRepository();
        });

    
        $this->app->bind(StockRepositoryInterface::class, function () {

            $request = app(\Illuminate\Http\Request::class);

            if ($request->type == 'Purchase') {return new PurchaseRepository();}
            if ($request->type == 'Sale') {return new SaleRepository();}
            if ($request->type == 'Supply') {return new SupplyRepository();}
            if ($request->type == 'Cash') {return new CashRepository();}
            if ($request->type == 'Transfer') {return new TransferRepository();}
            if ($request->type == 'PurchaseReturn') {return new PurchaseReturnRepository();}
            if ($request->type == 'SaleReturn') {return new SaleReturnRepository();
            }

            return new PurchaseRepository();
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
