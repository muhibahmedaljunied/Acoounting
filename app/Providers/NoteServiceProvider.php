<?php

namespace App\Providers;
use App\RepositoryInterface\NoteRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repository\Note\ExpenceRepository;
use App\Repository\Note\PaymentBondRepository;
use App\Repository\Note\ReceivableBondRepository;

class NoteServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        
        $request = app(\Illuminate\Http\Request::class);

        $this->app->bind(NoteRepositoryInterface::class, function ( ) use($request)  {
            
         
       
            if ($request->type == 'Expence') {

                return new ExpenceRepository();
            }

            if ($request->type == 'ReceivableBond') {

                return new ReceivableBondRepository();
            }


            if ($request->type == 'PaymentBond') {

                return new PaymentBondRepository();
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
