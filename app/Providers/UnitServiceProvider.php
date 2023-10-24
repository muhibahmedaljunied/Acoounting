<?php

namespace App\Providers;
use App\RepositoryInterface\UnitRepositoryInterface;
use App\Repository\Unit\UnitTransferRepository;
use App\Repository\Unit\UnitReturnRepository;
use App\Repository\Unit\UnitRepository;
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


            if ($request->type == 'Purchase' || $request->type == 'Sale') {

                return new UnitRepository();
            }

        

            if ($request->type == 'PurchaseReturn' || $request->type == 'SaleReturn') {

                return new UnitReturnRepository();
            }


            if ($request->type == 'Transfer') {

                return new UnitTransferRepository();
            }
            return new UnitTransferRepository();
          




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
