<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repository\HR\AttendRepository;
use App\Repository\HR\AbsenceRepository;
use App\RepositoryInterface\AttendanceRepositoryInterface;
use App\Services\core\CoreStaffAttendanceService;
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

        // $this->app->singleton('return', function () {
        //     return new MuhibService();
        // });


        $this->app->singleton(CoreService::class, function () {
            
            return new CoreService();
        });

        $this->app->singleton(CoreStaffService::class, function () {
            
            return new CoreStaffService();
        });

        $this->app->singleton(CoreStaffAttendanceService::class, function () {
            
            return new CoreStaffAttendanceService();
        });




        // $this->app->bind(AttendanceRepositoryInterface::class, function () {
        //     $request = app(\Illuminate\Http\Request::class);

        //     if ($request['attendance_status'][$value] == 1) {

        //         return new AttendRepository();
        //     } else {

        //         return new AbsenceRepository();
        //     }
        // });
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
