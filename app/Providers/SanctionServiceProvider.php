<?php

namespace App\Providers;
use App\Repository\Sanction\DelayRepository;
use App\Repository\Sanction\AbsenceRepository;
use App\Repository\Sanction\ExtraRepository;
use App\Repository\Sanction\LeaveRepository;
use App\RepositoryInterface\SanctionRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class SanctionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(SanctionRepositoryInterface::class, function () {

            $request = app(\Illuminate\Http\Request::class);

            if ($request->type == 'delay') {

                return new DelayRepository();
            }

            if ($request->type == 'extra') {

                return new ExtraRepository();
            }

            if ($request->type == 'leave') {

                return new LeaveRepository();
            }

            if ($request->type == 'absence') {

                return new AbsenceRepository();
            }



        



        });

        // $this->app->bind(SanctionRepositoryInterface::class, function ($app) {


        //     return collect([
             
        //         'absence_sanction' => app(AbsenceRepository::class),
        //         'extra_sanction' => app(ExtraRepository::class),
        //         'leave_sanction' => app(LeaveRepository::class),
        //         'delay_sanction' => app(DelayRepository::class),
                
        //     ]);
        // });

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
