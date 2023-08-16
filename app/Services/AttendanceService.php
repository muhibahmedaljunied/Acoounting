<?php

namespace App\Services;

use App\RepositoryInterface\SanctionRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Models\AttendanceDetail;
use App\Models\Attendance;
use App\RepositoryInterface\HRRepositoryInterface;
use App\Repository\Sanction\DelayRepository;
use DB;

class AttendanceService
{

    public function __construct(
        protected DetailRepositoryInterface $details,
        protected HRRepositoryInterface $hr
    ) {
        $this->details = $details;
        $this->hr = $hr;
    }

    public function absence($request, $value)
    {


        $attendance_id = $this->get($request['attendance_date'], $request['staff'][$value]);

        if ($attendance_id == 0) {

            $attendance_id = $this->create($request, $value);
            $this->sanction($attendance_id, $request, $value);
        }
    }

    public function attende($request, $value)
    {


        $updating_data = $this->check_attendance($request, $value);
        $attendance_id = $this->get($request['attendance_date'], $request['staff'][$value]);

        if ($attendance_id == 0) {

            $attendance_id = $this->add($request, $attendance_id, $value);
        } else {


            $this->handle_details($request, $updating_data, $attendance_id, $value);

            if ($request->post('attendance_final') == 'complete') {

                $this->sanction($attendance_id, $request, $value);
            }
        }
    }

    function handle_details($request, $updating_data, $attendance_id, $value)
    {


        $temporale_f = $this->refresh_details($request, $updating_data, $attendance_id);

        if ($temporale_f->isEmpty()) {

            $this->details->init_details(data: $request, id: $attendance_id, value: $value);
        }

        return $temporale_f;
    }

    function add($request, $attendance_id, $value)
    {


        $attendance_id = $this->create($request, $value);
        $this->details->init_details(data: $request, id: $attendance_id, value: $value);
    }

    function refresh_details($request, $data = null, $id)
    {

        $temporale_f = tap(AttendanceDetail::where([

            'attendance_id' => $id,
            'period_id' => $request['period']
        ]))
            ->update($data)
            ->get('id');
        return $temporale_f;
    }
    public function sanction($attendance_id, $request, $value)
    {


        // $this->update($attendance_id); //this must be observer

        foreach (config('sanction.data_sanction') as $value_sanction) {


            $repo = app(SanctionRepositoryInterface::class)->get($value_sanction);

            $repo->create($attendance_id, $request, $value, $value_sanction);
        }
    }

    // public function update($id)
    // {

    //     $attend = tap(Attendance::where('id', $id))
    //         ->update([
    //             'attendance_final' => 'complete',
    //         ])
    //         ->get('id');
    // }



    public function check_attendance($request, $value)
    {



        if ($request['attendance_in_out'] == 1) {

            $updating_data = [
                // 'attendance_status' => $request->post('attendance_status')[$value],
                'check_in' => $request->post('time_in')[$value]
            ];
        } else {

            $updating_data = [
                // 'attendance_status' => $request->post('attendance_status')[$value],
                'check_in' => $request->post('time_in')[$value],
                'check_out' => $request->post('time_out')[$value],
                'delay' => $request->post('delay')[$value],
                'leave' => $request->post('leave')[$value],
                'extra' => $request->post('extra')[$value],
                'duration' => $request->post('duration')[$value],
                // 'attendance_final' => $request->post('attendance_final')[$value]

            ];
        }

        return $updating_data;
    }


    public function get($date, $staff)
    {



        $attendance_id = Attendance::where(['attendance_date' => $date, 'staff_id' => $staff])
            ->select('attendances.id')
            ->get();

        if ($attendance_id->isEmpty()) {

            return $attendance_id = 0;
        } else {


            foreach ($attendance_id as $values) {
                $attendance_id = $values['id'];
            }

            return $attendance_id;
        }
    }




    function create($request, $value)
    {


        $attendance = new Attendance();
        $attendance->staff_id =  $request['staff'][$value];
        $attendance->attendance_date = $request['attendance_date'];
        $attendance->attendance_status = $request['attendance_status'][$value];
        $attendance->save();
        return $attendance->id;
    }
}
