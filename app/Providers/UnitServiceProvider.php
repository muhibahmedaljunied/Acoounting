<?php

namespace App\Providers;

use App\Repository\Unit\UnitDecodeRepository;
use App\Repository\Unit\UnitEncodeRepository;
use App\Repository\Unit\UnitReturnRepository;
use App\Repository\Unit\UnitTransferRepository;
use Illuminate\Support\ServiceProvider;
use App\RepositoryInterface\UnitRepositoryInterface;
use App\Services\CoreService;

class UnitServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {


        $core = app(CoreService::class);
        // $request = app(\Illuminate\Http\Request::class);

        $this->app->bind(UnitRepositoryInterface::class, function () use ($core) {

            $request = app(\Illuminate\Http\Request::class);

            // dd($request->all());

            if ($request->type == 'Purchase' || $request->type == 'Supply') {

                return new UnitDecodeRepository($core);
            }

            if ($request->type == 'Sale' || $request->type == 'Cash') {

                return new UnitEncodeRepository($core);
            }


            if ($request->type == 'Transfer') {

                return new UnitTransferRepository($core);
            }

            if (
                $request->type == 'SaleReturn' ||
                $request->type == 'PurchaseReturn' ||
                $request->type == 'CashReturn' ||
                $request->type == 'SupplyReturn'
            ) {

                return new UnitReturnRepository($core);
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
