<?php

namespace App\Http\Controllers\Staff;
use App\RepositoryInterface\HRRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use App\Models\AdministrativeStructure;
use App\Http\Controllers\Controller;
use App\Models\PeriodTime;
use App\Models\WorkSystem;
use App\Models\Qualification;
use App\Models\Branch;
use App\Models\Staff;
use App\Models\Nationality;
use App\Models\StaffType;
use App\Models\StaffReligion;
use Illuminate\Http\Request;
use DB;

class StaffController extends Controller
{
 
    public function index()
    {


        $staff_list = Cache::rememberForever('staff_eager_load_e', function () {

            return Staff::with([

                'department' => function ($query) {
                    $query->select('*');
                },
                'job' => function ($query) {
                    $query->select('*');
                },
                'qualification' => function ($query) {
                    $query->select('*');
                },
                'branch' => function ($query) {
                    $query->select('*');
                },
                'staff_type' => function ($query) {
                    $query->select('*');
                },
                // 'work_type' => function ($query) {
                //     $query->select('*');
                // },
                'staff_religion' => function ($query) {
                    $query->select('*');
                },
                'nationality' => function ($query) {
                    $query->select('*');
                }

            ])
                ->paginate(10);
        });

        // dd($staff_list);

        $period_times = PeriodTime::join('periods', 'periods.id', '=', 'period_times.period_id')
        ->select(
            'periods.*',
            'periods.id as period_id',
            'period_times.*',
            'period_times.id as period_time_id',
        )
        ->get();


   
        return response()->json([

            'qualifications' => Qualification::all(),
            'nationalities' => Nationality::all(),
            'staff_types' => StaffType::all(),
            'staff_religions' => StaffReligion::all(),
            'list' => $staff_list,
            'branches' => Branch::all(),
            'staffs' => $this->get_staff(),
            'work_systems' =>WorkSystem::all(),
            'period_times'=>$period_times
            
        ]);
    }

    public function get_job(Request $request)
    {


        $jobs = AdministrativeStructure::where('administrative_structures.parent_id', $request->id)
            ->select('administrative_structures.*')
            ->get();

        return response()->json(['jobs' => $jobs]);
    }




    public function select_staff(Request $request)
    {

        $staffs = DB::table('staff')
            ->where('staff.id', $request->id)
            ->join('qualifications', 'qualifications.id', '=', 'staff.qualification_id')
            ->join('branches', 'branches.id', '=', 'staff.branch_id')
            ->join('departments', 'departments.id', '=', 'staff.department_id')
            ->join('jobs', 'jobs.id', '=', 'staff.job_id')
            ->join('staff_types', 'staff_types.id', '=', 'staff.staff_type_id')
            ->join('staff_religions', 'staff_religions.id', '=', 'staff.religion_id')
            ->join('nationalities', 'nationalities.id', '=', 'staff.nationality_id')
            ->select('staff.id', 'staff.email', 'staff.date', 'staff.name as staff', 'staff.staff_status as status', 'staff.gender', 'staff.social_status', 'qualifications.name as qualification', 'branches.name  as branch', 'departments.name as department', 'jobs.name  as job', 'staff_types.name as staff_types', 'staff_religions.name as religion', 'nationalities.name as nationality')
            ->paginate(10);

        return response()->json(['list' => $staffs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {


        // return response()->json($request->all());
        $staff = new Staff();
        $staff->name = $request->post('name');
        $staff->personal_card = $request->post('card');
        $staff->job_id = $request->post('job');
        $staff->branch_id = $request->post('branch');
        $staff->department_id = $request->post('department');
        $staff->phone = $request->post('phone');
        // $staff->work_type_id = $request->post('work');
        $staff->date = $request->post('date');
        $staff->staff_status = $request->post('staff_status');
        $staff->qualification_id = $request->post('qualification');
        $staff->nationality_id = $request->post('nationality');
        $staff->gender = $request->post('gender');
        $staff->staff_type_id = $request->post('staff_type');
        $staff->barth_date = $request->post('barth_date');
        $staff->religion_id = $request->post('religion');
        $staff->social_status = $request->post('social_status');
        $staff->email = $request->post('email');
        // $staff->salary = $request->post('salary');
        $staff->save();

        //----------------------------------------------------------------------------------------------- 
        // $payroll = new Payroll();
        // $payroll->staff_id = $staff->id;
        // $payroll->net_salary = $request->post('salary');
        // $payroll->save();

        Cache::forget('staff');
        Cache::forget('staff_eager_load_e');



        return response()->json($request->all());
    }


    public function sanction_report(Request $request)
    {


        // $extra_details = DB::table('extras')->where('extras.staff_id', 1)
        //         ->join('extra_details', 'extra_details.extra_id', '=', 'extras.id')
        //         ->select('extra_details.*')
        //         ->get();   



        //         dd($extra_details);

        $staff = DB::table('staff_sanctions')
            ->join('staff', 'staff.id', '=', 'staff_sanctions.staff_id')
            ->select('staff_sanctions.*', 'staff_sanctions.date as sanction_date', 'staff.*')
            ->paginate(100);
        // --------------------------------------------------------------------------------------------------------

        foreach ($staff as $value) {

            if ($request->post('value_search') == 1 && $value->sanctionable_type == 'App\\Models\\AbsenceSanction') {
                $absence = DB::table('absence_sanctions')
                    ->join('absence_types', 'absence_types.id', '=', 'absence_sanctions.absence_type_id')
                    ->select('absence_sanctions.*', 'absence_types.*')
                    ->get();



                $value->AbsenceSanction = $absence;
                $value->type = 'غياب';
            }
            if ($request->post('value_search') == 2 && $value->sanctionable_type == 'App\\Models\\DelaySanction') {

                $delay = DB::table('delay_sanctions')->where('delay_sanctions.id', $value->sanctionable_id)
                    ->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id')
                    ->join('parts', 'parts.id', '=', 'delay_sanctions.part_id')
                    ->select('delay_sanctions.*', 'delay_types.*','parts.name as parts_name')
                    ->get();


                $value->DelaySanction = $delay;
                $value->type = 'تأخير';
            }
            if ($request->post('value_search') == 4) {


                if ($value->sanctionable_type == 'App\\Models\\ExtraSanction') {

                    $extra_sanction = DB::table('extra_sanctions')->where('extra_sanctions.id', $value->sanctionable_id)
                        ->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id')
                        ->select('extra_sanctions.*', 'extra_types.*')
                        ->get();


                    $value->ExtraSanction = $extra_sanction;
                }


                $extra_details = DB::table('extras')->where('extra_sanctions.id',$value->sanctionable_id)
                    ->join('extra_details', 'extra_details.extra_id', '=', 'extras.id')
                    ->join('extra_sanctions', 'extra_sanctions.id', '=', 'extra_details.extra_sanction_id')
                    ->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id')
                    ->select('extra_details.*','extra_sanctions.*','extra_types.*')
                    ->get();

                $value->ExtraDetails = $extra_details;

                $value->type = 'اضافي';
            }
            if ($request->post('value_search') == 3 && $value->sanctionable_type == 'App\\Models\\LeaveSanction') {

                $leave = DB::table('leave_sanctions')->where('leave_sanctions.id', $value->sanctionable_id)
                    ->join('leave_types', 'leave_types.id', '=', 'leave_sanctions.leave_type_id')
                    ->join('parts', 'parts.id', '=', 'leave_sanctions.part_id')
                    ->select('leave_sanctions.*', 'leave_types.*','parts.name as parts_name')
                    ->get();;

                $value->LeaveSanction = $leave;
                $value->type = 'انصراف مبكر';
            }
        }


        return response()->json(['list' => $staff]);
    }

    public function sanction(HRRepositoryInterface $hr)
    {
        $advances = Staff::with(['advance'])->paginate(10);
        $hr->Sum($advances, 'advance');
        // ---------------------------------
        $staffs =  $this->get_staff();

        return response()->json(['staffs' => $staffs, 'list' => $advances]);
    }



    public function get_staff()
    {

        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });

        return $staffs;
    }


    public function show(Request $request)
    {
    }

    public function edit(Staff $staff)
    {
        //
    }

    public function update(Request $request, Staff $staff)
    {
        //
    }

    public function destroy($id)
    {

        // DB::table('payrolls')->where('staff_id', '=', $id)->delete();

        $store = staff::find($id);

        $store->delete();

        Cache::forget('staff');
        Cache::forget('staff_eager_load_e');


        return response()->json('successfully deleted');
    }
}
