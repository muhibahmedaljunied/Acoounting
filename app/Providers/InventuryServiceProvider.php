<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\RepositoryInterface\InventuryStoreRepositoryInterface;
use App\RepositoryInterface\InventuryStockRepositoryInterface;
use App\Repository\StoreInventury\StoreSaleRepository;
use App\Repository\StockInventury\StockSaleRepository;
use App\Repository\StoreInventury\StorePurchaseRepository;
use App\Repository\StockInventury\StockPurchaseRepository;
use App\Services\CoreService;

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
            $core = app(CoreService::class);
            if ($request->type == 'purchase') {

                return new StorePurchaseRepository($core);
            }

            if ($request->type == 'sale') {

                return new StoreSaleRepository($core);
            }

            return new StorePurchaseRepository($core);
        });


        $this->app->bind(InventuryStockRepositoryInterface::class, function () {

            $request = app(\Illuminate\Http\Request::class);
            $core = app(CoreService::class);
            if ($request->type == 'purchase') {

                return new StockPurchaseRepository($core);
            }

            if ($request->type == 'sale') {

                return new StockSaleRepository($core);
            }

            return new StockSaleRepository($core);
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
