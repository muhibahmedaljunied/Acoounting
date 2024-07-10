<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\RepositoryInterface\StoreProductRepositoryInterface;
use App\Repository\Return\PurchaseReturnRepository;
use App\Repository\Return\SaleReturnRepository;
use App\Repository\Stock\PurchaseRepository;
use App\Repository\Stock\SaleRepository;
use App\Repository\Stock\SupplyRepository;
use App\Repository\Stock\CashRepository;
use App\Repository\Stock\TransferRepository;
use App\Repository\StockInventury\StockCashRepository;
use App\Repository\StockInventury\StockPurchaseRepository;
use App\Repository\StockInventury\StockRepository;
use App\Repository\StockInventury\StockSaleRepository;
use App\Repository\StockInventury\StockSupplyRepository;
use App\Repository\StockReturnInventury\StockCashReturnRepository;
use App\Repository\StockReturnInventury\StockPurchaseReturnRepository;
use App\Repository\StockReturnInventury\StockReturnRepository;
use App\Repository\StockReturnInventury\StockSaleReturnRepository;
use App\Repository\StockReturnInventury\StockSupplyReturnRepository;
use App\Repository\StoreInventury\StoreCashRepository;
use App\Repository\StoreInventury\StorePurchaseRepository;
use App\Repository\StoreInventury\StoreRepository;
use App\Repository\StoreInventury\StoreSaleRepository;
use App\Repository\StoreInventury\StoreSupplyRepository;
use App\Repository\StoreInventury\StoreCashReturnRepository;
use App\Repository\StoreInventury\StorePurchaseReturnRepository;
use App\Repository\StoreReturnInventury\StoreReturnRepository;
use App\Repository\StoreInventury\StoreSaleReturnRepository;
use App\Repository\StoreInventury\StoreSupplyReturnRepository;
use App\RepositoryInterface\StoreRepositoryInterface;
use App\Services\CoreService;

class StockServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {


        $core = app(CoreService::class);
        $request = app(\Illuminate\Http\Request::class);

        // $this->app->bind(StoreProductRepositoryInterface::class, function () {

        //     $request = app(\Illuminate\Http\Request::class);

        //     if ($request->type == 'Purchase') {

        //         return new PurchaseRepository();
        //     }

        //     if ($request->type == 'Sale') {

        //         return new SaleRepository();
        //     }

        //     if ($request->type == 'Supply') {

        //         return new SupplyRepository();
        //     }


        //     if ($request->type == 'Cash') {

        //         return new CashRepository();
        //     }
        //     if ($request->type == 'Transfer') {

        //         return new TransferRepository();
        //     }

        //     if ($request->type == 'PurchaseReturn') {

        //         return new PurchaseReturnRepository();
        //     }

        //     if ($request->type == 'SaleReturn') {

        //         return new SaleReturnRepository();
        //     }


        //     return new PurchaseRepository();
        // });

        // ------------------------------------------------------------------------------------------------------
        // $this->app->bind(StoreReturnRepository::class, function () use ($core, $request) {




        //     if ($request->type == 'PurchaseReturn') {
        //         return new StorePurchaseReturnRepository($core);
        //     }
        //     if ($request->type == 'SaleReturn') {
        //         return new StoreSaleReturnRepository($core);
        //     }

        //     if ($request->type == 'SupplyReturn') {
        //         return new StoreSupplyReturnRepository($core);
        //     }
        //     if ($request->type == 'CashReturn') {
        //         return new StoreCashReturnRepository($core);
        //     }
        // });

        // $this->app->bind(StockReturnRepository::class, function () use ($core, $request) {

        //     if ($request->type == 'PurchaseReturn') {
        //         return new StockPurchaseReturnRepository($core);
        //     }
        //     if ($request->type == 'SaleReturn') {
        //         return new StockSaleReturnRepository($core);
        //     }

        //     if ($request->type == 'SupplyReturn') {
        //         return new StockSupplyReturnRepository($core);
        //     }
        //     if ($request->type == 'CashReturn') {
        //         return new StockCashReturnRepository($core);
        //     }
        // });

        $this->app->bind(StoreRepositoryInterface::class, function () use ($core, $request) {




            if ($request->type == 'Purchase') {
                return new StorePurchaseRepository($core);
            }
            if ($request->type == 'Sale') {
                return new StoreSaleRepository($core);
            }

            if ($request->type == 'Supply') {
                return new StoreSupplyRepository($core);
            }
            if ($request->type == 'Cash') {
                return new StoreCashRepository($core);
            }

            if ($request->type == 'PurchaseReturn') {
                return new StorePurchaseReturnRepository($core);
            }
            if ($request->type == 'SaleReturn') {

                return new StoreSaleReturnRepository($core);
            }

            if ($request->type == 'SupplyReturn') {
                return new StoreSupplyReturnRepository($core);
            }
            if ($request->type == 'CashReturn') {
                return new StoreCashReturnRepository($core);
            }
            
        });

        // $this->app->bind(StockRepository::class, function () use ($core, $request) {

        //     if ($request->type == 'Purchase') {
        //         return new StockPurchaseRepository($core);
        //     }
        //     if ($request->type == 'Sale') {
        //         return new StockSaleRepository($core);
        //     }

        //     if ($request->type == 'Supply') {
        //         return new StockSupplyRepository($core);
        //     }
        //     if ($request->type == 'Cash') {
        //         return new StockCashRepository($core);
        //     }
        // });

        // $this->app->bind(StockRepositoryInterface::class, function () {

        //     $request = app(\Illuminate\Http\Request::class);

        //     if ($request->type == 'Purchase') {return new PurchaseRepository();}
        //     if ($request->type == 'Sale') {return new SaleRepository();}
        //     if ($request->type == 'Supply') {return new SupplyRepository();}
        //     if ($request->type == 'Cash') {return new CashRepository();}
        //     if ($request->type == 'Transfer') {return new TransferRepository();}
        //     if ($request->type == 'PurchaseReturn') {return new PurchaseReturnRepository();}
        //     if ($request->type == 'SaleReturn') {return new SaleReturnRepository();
        //     }

        //     return new PurchaseRepository();
        // });






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
