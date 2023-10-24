<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\Repository\Return\PurchaseReturnRepository;
use App\Repository\Return\SaleReturnRepository;
use App\Repository\Stock\PurchaseRepository;
use App\Repository\Stock\SaleRepository;
use App\Repository\Stock\SupplyRepository;
use App\Repository\Stock\CashRepository;
use App\Repository\HR\AttendanceRepository;
use App\Repository\Stock\TransferRepository;
use App\Services\CoreStaffService;
use App\Repository\HR\ExtraRepository;

class DetailServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        
    
        $this->app->bind(DetailRepositoryInterface::class, function () {
            $request = app(\Illuminate\Http\Request::class);

            $core = app(CoreStaffService::class);

            if ($request->type == 'PurchaseReturn') {

                return new PurchaseReturnRepository();
            }

            if ($request->type == 'SaleReturn') {

                return new SaleReturnRepository();
            }
            
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
            if ($request->type == 'extra') {

                return new ExtraRepository($core);
            }
            if ($request->type == 'attendance') {

                return new AttendanceRepository();
            }

            return new PurchaseRepository();
        });


        $this->app->bind(DetailRefreshRepositoryInterface::class, function () {
            $request = app(\Illuminate\Http\Request::class);

            if ($request->type == 'PurchaseReturn') {

                return new PurchaseReturnRepository();
            }

            if ($request->type == 'SaleReturn') {

                return new SaleReturnRepository();
            }

            // if ($request->type == 'Supply') {

            //     return new SupplyReturnRepository();
            // }


            // if ($request->type == 'Cash') {

            //     return new CashReturnRepository();
            // }

          

            return new PurchaseReturnRepository();
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
