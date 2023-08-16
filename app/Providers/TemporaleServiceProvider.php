<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\RepositoryInterface\TemporaleRepositoryInterface;
use App\Repository\Stock\PurchaseRepository;
use App\Repository\Stock\SaleRepository;
use App\Repository\Stock\SupplyRepository;
use App\Repository\Stock\CashRepository;

class TemporaleServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        
       


        
        $this->app->bind(TemporaleRepositoryInterface::class, function () {
            $request = app(\Illuminate\Http\Request::class);

            if ($request->type == 'Purchase') {

                return (new PurchaseRepository())->add(1);
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

            return new PurchaseRepository();


            // return app(MyImplementation::class, [$request->foo]);
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
