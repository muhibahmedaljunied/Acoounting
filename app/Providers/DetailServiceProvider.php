<?php

namespace App\Providers;

use App\Repository\Stock\CashDetailRepository;
use App\Repository\Stock\CashReturnDetailRepository;
use App\Repository\Stock\CashReturnRefreshDetailRepository;
use App\Repository\Stock\PurchaseDetailRepository;
use App\Repository\Stock\PurchaseRefreshDitailRepository;
use App\Repository\Stock\PurchaseReturnDetailRepository;
use App\Repository\Stock\PurchaseReturnRefreshDetailRepository;
use Illuminate\Support\ServiceProvider;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\Repository\Stock\PurchaseReturnRepository;
use App\Repository\Stock\SaleDetailRepository;
use App\Repository\Stock\SaleRefreshDetailRepository;
use App\Repository\Stock\SaleRefreshDitailRepository;
use App\Repository\Stock\SaleReturnDetailRepository;
use App\Repository\Stock\SaleReturnRefreshDetailRepository;
use App\Repository\Stock\SaleReturnRepository;
use App\Repository\Stock\SupplyDetailRepository;
use App\Repository\Stock\SupplyReturnDetailRepository;
use App\Repository\Stock\SupplyReturnRefreshDetailRepository;

class DetailServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        
        $request = app(\Illuminate\Http\Request::class);

        $this->app->bind(DetailRepositoryInterface::class, function ( ) use($request)  {
            
         

            if ($request->type == 'Purchase') {
           
                return new PurchaseDetailRepository();

            } 

            if ($request->type == 'Sale') {
           
                return new SaleDetailRepository();

            } 

            if ($request->type == 'Supply') {
           
                return new SupplyDetailRepository();

            } 

            if ($request->type == 'Cash') {
           
                return new CashDetailRepository();

            } 

            if ($request->type == 'PurchaseReturn') {
           
                return new PurchaseReturnDetailRepository();

            } 

            if ($request->type == 'SaleReturn') {
           
                return new SaleReturnDetailRepository();

            } 

            if ($request->type == 'SupplyReturn') {
           
                return new SupplyReturnDetailRepository();

            } 

            if ($request->type == 'CashReturn') {
           
                return new CashReturnDetailRepository();

            } 

           


          
        });

        // $this->app->bind(DetailRefreshRepositoryInterface::class, function ( ) use($request)  {
            
         
        //     if ($request->type == 'Purchase') {
           
        //         return new PurchaseRefreshDitailRepository();

        //     } 

        //     if ($request->type == 'Sale') {
           
        //         return new SaleRefreshDetailRepository();

        //     } 
        //     if ($request->type == 'Supply') {
           
        //         return new SupplyReturnRefreshDetailRepository();

        //     } 

        //     if ($request->type == 'Cash') {
           
        //         return new CashReturnRefreshDetailRepository();

        //     } 


        //     if ($request->type == 'PurchaseReturn') {
           
        //         return new PurchaseReturnRefreshDetailRepository();

        //     } 

        //     if ($request->type == 'SaleReturn') {
           
        //         return new SaleReturnRefreshDetailRepository();

        //     } 
        //     if ($request->type == 'SupplyReturn') {
           
        //         return new SupplyReturnRefreshDetailRepository();

        //     } 

        //     if ($request->type == 'CashReturn') {
           
        //         return new CashReturnRefreshDetailRepository();

        //     } 

           


          
        // });


        // $this->app->bind(DetailRepositoryInterface::class, function ( ) use($request)  {
            
         
        //     if ($request->type == 'PurchaseReturn' || $request->type == 'Purchase' ) {
           
        //         return $this->details_purchase($request);
        //     } 

        //     if ($request->type == 'SaleReturn' || $request->type == 'Sale' ) {
           
        //         return $this->details_sale($request);
        //     } 

        //     if ($request->type == 'Transfer') {
           
        //         return  $this->details_transfer($request);
        //     } 

        //     if ($request->type == 'extra' || $request->type == 'attendance') {
           
        //         return  $this->hr($request);
        //     } 


        //     // $this->details_cash($request);
        //     // $this->details_supply($request);
        //     // $this->hr($request);
       
           
        // });

        // $this->app->bind(DetailRefreshRepositoryInterface::class, function () use($request ) {
          
        //     return $this->refresh_detail_returns($request);
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

    public function refresh_detail_returns($request)
    {


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

        // return new PurchaseReturnRepository();
    }

    public function details_sale($request)
    {

        if ($request->type == 'Sale') {

            return new SaleRepository();
        }

        if ($request->type == 'SaleReturn') {

            return new SaleReturnRepository();
        }
    }

    public function details_cash($request)
    {

        if ($request->type == 'Cash') {

            return new CashRepository();
        }
    }

    public function details_supply($request)
    {

        if ($request->type == 'Supply') {

            return new SupplyRepository();
        }
    }
    public function details_purchase($request)
    {



        if ($request->type == 'PurchaseReturn') {

            return new PurchaseReturnRepository();
        }


        if ($request->type == 'Purchase') {

            return new PurchaseRepository();
        }


    }

    public function details_transfer($request)
    {


        if ($request->type == 'Transfer') {

            return new TransferRepository();
        }
    }



    public function hr($request)
    {

        $core = app(CoreStaffService::class);
        if ($request->type == 'extra') {

            return new ExtraRepository($core);
        }
        if ($request->type == 'attendance') {

            return new AttendanceRepository();
        }

     
    }
}
