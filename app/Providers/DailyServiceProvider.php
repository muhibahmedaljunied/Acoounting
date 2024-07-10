<?php

namespace App\Providers;
use App\RepositoryInterface\DailyRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repository\Daily\ExpenceRepository;
use App\Repository\Daily\PaymentBondRepository;
use App\Repository\Daily\ReceivableBondRepository;
use App\Repository\Daily\PurchaseRepository;
use App\Repository\Daily\SaleRepository;
use App\Repository\Daily\PurchaseReturnRepository;
use App\Repository\Daily\SaleReturnRepository;

class DailyServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        
        $request = app(\Illuminate\Http\Request::class);

        $this->app->bind(DailyRepositoryInterface::class, function ( ) use($request)  {
            
         
       
            if ($request->type == 'Expence') {

                return new ExpenceRepository();
            }

            if ($request->type == 'ReceivableBond') {

                return new ReceivableBondRepository();
            }


            if ($request->type == 'PaymentBond') {

                return new PaymentBondRepository();
            }
            if ($request->type == 'Sale') {

                return new SaleRepository();
            }

            if ($request->type == 'SaleReturn') {

                return new SaleReturnRepository();
            }

            if ($request->type == 'Purchase') {

                return new PurchaseRepository();
            }

            if ($request->type == 'PurchaseReturn') {

                return new PurchaseReturnRepository();
            }

          

       
           
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
