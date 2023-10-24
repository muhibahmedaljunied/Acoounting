<?php

namespace App\Providers;
use App\Repository\HR\ExtraRepository;
use App\Repository\HR\AdvanceRepository;
use App\Repository\HR\AllowanceRepository;
use App\Repository\HR\DiscountRepository;
use App\Repository\HR\VacationRepository;
use App\RepositoryInterface\PayrollRepositoryInterface;
use App\Services\CoreStaffService;

use Illuminate\Support\ServiceProvider;

class PayrollServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

               
        $this->app->bind(PayrollRepositoryInterface::class, function () {

            $request = app(\Illuminate\Http\Request::class);
            $core = app(CoreStaffService::class);

            if ($request->type == 'extra') {

                return new ExtraRepository($core);
            }

            if ($request->type == 'advance') {

                return new AdvanceRepository($core);
            }

            if ($request->type == 'discount') {

                return new DiscountRepository($core);
            }


            if ($request->type == 'vacation') {

                return new VacationRepository($core);
            }

            if ($request->type == 'allowance') {

                return new AllowanceRepository($core);
            }


            return new AdvanceRepository($core);


            // return app(MyImplementation::class, [$request->foo]);
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
