<?php

namespace App\Providers;


use App\Repository\HR\ExtraRepository;
use App\Repository\HR\AdvanceRepository;
use App\Repository\HR\AllowanceRepository;
use App\Repository\HR\DiscountRepository;
use App\Repository\HR\VacationRepository;
use App\RepositoryInterface\HRRepositoryInterface;

use Illuminate\Support\ServiceProvider;

class HRServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(HRRepositoryInterface::class, function () {

            $request = app(\Illuminate\Http\Request::class);

            if ($request->type == 'extra') {

                return new ExtraRepository();
            }

            if ($request->type == 'advance') {

                return new AdvanceRepository();
            }

            if ($request->type == 'discount') {

                return new DiscountRepository();
            }


            if ($request->type == 'vacation') {

                return new VacationRepository();
            }

            if ($request->type == 'allowance') {

                return new AllowanceRepository();
            }


            return new ExtraRepository();
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
