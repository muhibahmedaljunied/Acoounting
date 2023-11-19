<?php

namespace App\Providers;
use App\RepositoryInterface\InventuryStoreRepositoryInterface;
use App\RepositoryInterface\InventuryStockRepositoryInterface;
use App\Repository\StockInventury\StockTransferRepository;
use App\Repository\StoreInventury\StoreTransferRepository;
use App\Repository\StoreInventury\StorePurchaseRepository;
use App\Repository\StockInventury\StockPurchaseRepository;
use App\Repository\StoreInventury\StoreSaleRepository;
use App\Repository\StockInventury\StockSaleRepository;
use Illuminate\Support\ServiceProvider;
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
            if ($request->type == 'Purchase') {

                return new StorePurchaseRepository($core);
            }

            if ($request->type == 'Sale') {

                return new StoreSaleRepository($core);
            }

            
            if ($request->type == 'Transfer') {

                return new StoreTransferRepository($core);
            }

            return new StorePurchaseRepository($core);
        });


        $this->app->bind(InventuryStockRepositoryInterface::class, function () {

            $request = app(\Illuminate\Http\Request::class);
            $core = app(CoreService::class);
            if ($request->type == 'Purchase') {

                
                return new StockPurchaseRepository($core);
            }

            if ($request->type == 'Sale') {

                return new StockSaleRepository($core);
            }

            if ($request->type == 'Transfer') {

                return new StockTransferRepository($core);
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
