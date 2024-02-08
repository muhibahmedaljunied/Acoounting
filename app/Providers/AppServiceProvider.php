<?php

namespace App\Providers;
use App\Services\core\CoreStaffAttendanceService;
use App\Repository\Sanction\DelayRepository;
use App\Repository\Sanction\LeaveRepository;
use App\Repository\Sanction\AbsenceRepository;
use App\Repository\Sanction\ExtraRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\CoreStaffService;
use App\Services\CoreService;



class AppServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

       
  
   
        $this->app->singleton(CoreStaffAttendanceService::class, function () {
            
            return new CoreStaffAttendanceService();
        });
     
        $this->app->singleton('delay_sanction', function ()  {
            
            return new DelayRepository();
        });


        $this->app->singleton('absence_sanction', function (){
            
            return new AbsenceRepository();
        });

        $this->app->singleton('leave_sanction', function (){
            
            return new LeaveRepository();
        });

        $this->app->singleton('extra_sanction', function (){
            
      
            return new ExtraRepository();
        });

        $this->app->singleton(CoreService::class, function () {
            
            return new CoreService();
        });

        $this->app->singleton(CoreStaffService::class, function () {
            
            return new CoreStaffService();
        });

   

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

       
        DB::listen(function ($query) {
            Log::info(
                $query->sql,
                $query->bindings,
                $query->time
            );
        });
    }
}
