<?php

namespace App\Providers;
use App\RepositoryInterface\HRRepositoryInterface;
use App\Repository\HR\AbsenceSanctionRepository;
use App\Repository\HR\DelaySanctionRepository;
use App\Repository\HR\LeaveSanctionRepository;
use App\Repository\HR\ExtraSanctionRepository;
use App\Repository\HR\AdvanceRepository;
use App\Repository\HR\AllowanceRepository;
use App\Repository\HR\DiscountRepository;
use App\Repository\HR\VacationRepository;
use App\Repository\HR\ExtraRepository;
use App\Services\CoreStaffService;
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


            if ($request->type == 'leave') {

                return new VacationRepository($core);
            }

            if ($request->type == 'leave_sanction') {

                return new LeaveSanctionRepository($core);
            }


            if ($request->type == 'delay_sanction') {

                return new DelaySanctionRepository($core);
            }

            if ($request->type == 'extra_sanction') {

                return new ExtraSanctionRepository($core);
            }

            if ($request->type == 'absence_sanction') {

                return new AbsenceSanctionRepository($core);
            }



            if ($request->type == 'allowance') {

                return new AllowanceRepository($core);
            }


            return new ExtraRepository($core);
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
