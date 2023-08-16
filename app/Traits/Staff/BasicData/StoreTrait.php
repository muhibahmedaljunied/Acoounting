<?php

namespace App\Traits\Staff\BasicData;

use App\Models\AllowanceType;
use Illuminate\Http\Request;
use App\Models\PeriodWorkType;
use App\Models\WorkType;
use App\Models\Branch;
use App\Models\Nationality;
use App\Models\Qualification;
use App\Models\Period;
use App\Models\StaffReligion;
use App\Models\VacationType;
use App\Models\AbsenceType;
use App\Models\DelayType;
use App\Models\StaffType;
use App\Models\ExtraType;
use App\Models\ExtraPart;


use DB;

trait StoreTrait
{



    public function store(Request $request)
    {

        // return response()->json(['work_types'=>$request->all()]);

        foreach ($request->post('count') as $value) {



            if ($request->post('type') == 'work_system') {

                $temporale = new PeriodWorkType();
                // $temporale->work_type_id = $request['work_type'][$value];
                $temporale->work_type_id = $request['work_type'];

                $temporale->period_id = $request['period'][$value];
                // $temporale->rest_id = $request['rest'][$value];
                $temporale->day_id = json_encode($request['day'][$value]);
                $temporale->save();
            }

            if ($request->post('type') == 'work_type') {

                $temporale = new WorkType();
                $temporale->name = $request['name'][$value];
                $temporale->save();
            }

            if ($request->post('type') == 'branch') {

                $temporale = new Branch();
                $temporale->name = $request['name'][$value];
                $temporale->save();
            }

            if ($request->post('type') == 'allowance_type') {


                $temporale = new AllowanceType();
                $temporale->name = $request['name'][$value];
                $temporale->save();
            }

             if ($request->post('type') == 'qualification') {


                $temporale = new Qualification();
                $temporale->name = $request['name'][$value];
                $temporale->save();
            }

            if ($request->post('type') == 'period') {


                $temporale = new Period();
                $temporale->name = $request['period_name'][$value];
                $temporale->from_time = $request['from_period'][$value];
                $temporale->into_time = $request['into_period'][$value];
                $temporale->duration = $request['duration_period'][$value];
                $temporale->save();
            }

            if ($request->post('type') == 'religion') {


                $temporale = new StaffReligion();
                $temporale->name = $request['name'][$value];
                $temporale->save();
            }

            if ($request->post('type') == 'nationality') {


                $temporale = new Nationality();
                $temporale->name = $request['name'][$value];
                $temporale->save();
            }
            if ($request->post('type') == 'absence_type') {


                $temporale = new AbsenceType();
                $temporale->name = $request['name'][$value];

                $temporale->save();
            }
            if ($request->post('type') == 'vaction_type') {


                $temporale = new VacationType();
                $temporale->name = $request['name'][$value];
                $temporale->duration = $request['duration'][$value];

                $temporale->save();
            }
            if ($request->post('type') == 'staff_type') {


                $temporale = new StaffType();
                $temporale->name = $request['name'][$value];

                $temporale->save();
            }

            if ($request->post('type') == 'delay_type') {


                $temporale = new DelayType();
                $temporale->name = $request['name'][$value];
                $temporale->duration = $request['duration'][$value];

                $temporale->save();
            }

            if ($request->post('type') == 'extra_type') {


                $temporale = new ExtraType();
                $temporale->name = $request['name'][$value];
                $temporale->save();
            }

            if ($request->post('type') == 'extra_part') {


                $temporale = new ExtraPart();
                $temporale->name = $request['name'][$value];
                $temporale->from_time = $request['from_time'][$value];
                $temporale->into_time = $request['into_time'][$value];
                $temporale->save();
            }
        }




        return response()->json(['message' => $request->all()]);
    }
}
