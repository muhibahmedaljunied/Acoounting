<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\RepositoryInterface\InventuryStoreRepositoryInterface;
use App\RepositoryInterface\InventuryStockRepositoryInterface;
use App\Repository\StoreInventury\StoreSaleRepository;
use App\Repository\StockInventury\StockSaleRepository;
use App\Repository\StoreInventury\StorePurchaseRepository;
use App\Repository\StockInventury\StockPurchaseRepository;

class InventuryServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        
    

        $this->app->bind(InventuryStoreRepositoryInterface::class, function () {

            $request = app(\Illuminate\Http\Request::class);

            if ($request->type == 'purchase') {

                return new StorePurchaseRepository();
            }

            if ($request->type == 'sale') {

                return new StoreSaleRepository();
            }

            return new StorePurchaseRepository();
        });


        $this->app->bind(InventuryStockRepositoryInterface::class, function () {

            $request = app(\Illuminate\Http\Request::class);

            if ($request->type == 'purchase') {

                return new StockPurchaseRepository();
            }

            if ($request->type == 'sale') {

                return new StockSaleRepository();
            }

            return new StockSaleRepository();
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
