<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\RepositoryInterface\ReturnRepositoryInterface;
use App\Repository\Return\PurchaseReturnRepository;
use App\Repository\Return\SaleReturnRepository;
// use App\RepositoryInterface\DailyRepositoryInterface;

class ReturnServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        
        // $this->app->bind(ReturnRepositoryInterface::class, function () {

        //     $request = app(\Illuminate\Http\Request::class);

        //     if ($request->type == 'PurchaseReturn') {

        //         return new PurchaseReturnRepository();
        //     }

        //     if ($request->type == 'SaleReturn') {

        //         return new SaleReturnRepository();
        //     }

          

        //     return new PurchaseReturnRepository();
        // });

        // $this->app->bind(DailyRepositoryInterface::class, function () {

        //     $request = app(\Illuminate\Http\Request::class);

        //     if ($request->type == 'PurchaseReturn') {

        //         return new PurchaseReturnRepository();
        //     }

        //     if ($request->type == 'SaleReturn') {

        //         return new SaleReturnRepository();
        //     }

          

        //     return new PurchaseReturnRepository();
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
