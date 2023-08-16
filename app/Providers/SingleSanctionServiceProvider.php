<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Sanction\DelayRepository;
use App\Repository\Sanction\AbsenceRepository;
use App\Repository\Sanction\ExtraRepository;
use App\Repository\Sanction\LeaveRepository;

class SanctionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(SingleSanctionRepositoryInterface::class, function () {

            $request = app(\Illuminate\Http\Request::class);

            if ($request->type == 'delay_sanction') {

                return new DelayRepository();
            }

            if ($request->type == 'extra_sanction') {

                return new ExtraRepository();
            }

            if ($request->type == 'leave_sanction') {

                return new LeaveRepository();
            }

            if ($request->type == 'absence_sanction') {

                return new AbsenceRepository();
            }



        



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
