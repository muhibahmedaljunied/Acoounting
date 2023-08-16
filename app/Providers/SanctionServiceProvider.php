<?php

namespace App\Providers;
use App\Repository\ExtraRepository;
use App\Repository\LeaveRepository;
use App\Repository\DelayRepository;
use App\Repository\AbsenceRepository;
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

        $this->app->bind(SanctionRepositoryInterface::class, function ($app) {


            return collect([
             
                'absence_sanction' => app(AbsenceRepository::class),
                'extra_sanction' => app(ExtraRepository::class),
                'leave_sanction' => app(LeaveRepository::class),
                'delay_sanction' => app(DelayRepository::class),
                
            ]);
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
