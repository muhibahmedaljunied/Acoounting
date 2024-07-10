<?php

namespace App\Http\Controllers\Staff;

use App\Exports\HrSettingExport;
use App\RepositoryInterface\HRRepositoryInterface;
use App\Services\CoreStaffService;
use App\Services\Staff\StaffService;
use Illuminate\Support\Facades\Cache;
use App\Models\AdministrativeStructure;
use App\Http\Controllers\Controller;
use App\Imports\HrSettingImport;
use App\Models\Account;
use App\Models\PeriodTime;
use App\Models\WorkSystem;
use App\Models\Qualification;
use App\Models\Branch;
use App\Models\HrAccount;
use App\Models\Staff;
use App\Models\Nationality;
use App\Models\StaffType;
use App\Models\StaffReligion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StaffController extends Controller
{

    public function __construct(
        protected CoreStaffService $core,

    ) {
    }
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
            'work_systems' => WorkSystem::all(),
            'period_times' => $period_times

        ]);
    }

    public function import(Request $request)
    {

        Excel::import(new HrSettingImport, storage_path('hr_setting.xlsx'));

        return response()->json([
            'status' =>
            'The file has been excel/csv imported to database in laravel 9'
        ]);
    }


    public function export()
    {

        return Excel::download(new HrSettingExport, 'hr_setting.xlsx');
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



    public function store(Request $request, StaffService $staff_service)
    {

        // return response()->json($request->all());
        $this->core->setData($request->all());
        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction


            $staff_service->add_staff();
            // $staff_service->add_account();
            $staff_service->refresh_payroll();

            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

            return response([
                'message' => "staff created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {
            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }
    }


    public function sanction_report(Request $request)
    {


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
                    ->select('delay_sanctions.*', 'delay_types.*', 'parts.name as parts_name')
                    ->get();


                $value->DelaySanction = $delay;
                $value->type = 'تأخير';
            }
            // if ($request->post('value_search') == 4) {


            //     if ($value->sanctionable_type == 'App\\Models\\ExtraSanction') {

            //         $extra_sanction = DB::table('extra_sanctions')->where('extra_sanctions.id', $value->sanctionable_id)
            //             ->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id')
            //             ->select('extra_sanctions.*', 'extra_types.*')
            //             ->get();


            //         $value->ExtraSanction = $extra_sanction;
            //     }


            //     $extra_details = DB::table('extras')->where('extra_sanctions.id',$value->sanctionable_id)
            //         ->join('extra_details', 'extra_details.extra_id', '=', 'extras.id')
            //         ->join('extra_sanctions', 'extra_sanctions.id', '=', 'extra_details.extra_sanction_id')
            //         ->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id')
            //         ->select('extra_details.*','extra_sanctions.*','extra_types.*')
            //         ->get();

            //     $value->ExtraDetails = $extra_details;

            //     $value->type = 'اضافي';
            // }
            if ($request->post('value_search') == 3 && $value->sanctionable_type == 'App\\Models\\LeaveSanction') {

                $leave = DB::table('leave_sanctions')->where('leave_sanctions.id', $value->sanctionable_id)
                    ->join('leave_types', 'leave_types.id', '=', 'leave_sanctions.leave_type_id')
                    ->join('parts', 'parts.id', '=', 'leave_sanctions.part_id')
                    ->select('leave_sanctions.*', 'leave_types.*', 'parts.name as parts_name')
                    ->get();

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

    public function store_account_setting(Request $request)
    {



        foreach ($request->post('count') as $value) {

            // dd($request['name']);
            $staff = new HrAccount();
            $staff->name = $request['name'][$value];
            $staff->code = $request['code'][$value];
            $staff->type = $request['type_account'][$value];
            $staff->save();
        }




        return response()->json('successfully created');
    }

    public function store_staff_account_setting(Request $request)
    {


        // dd($request->all());
        $this->core->setData($request->all());
        $array_data =  HrAccount::all();

        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction


            foreach ($array_data as $value) {


                $this->Account_right($value);

                // $this->Account_left($value);

            }
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

            return response(
                [
                    'message' => "successfully created",
                    'status' => "success"
                ],
                200
            );
        } catch (\Exception $exp) {
            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }
    }

    public function Account_right($value)
    {


        // $re = $this->core->data['staff_' . $value->code . '' . $value->type . '_second_account_id'];
        // $xe =  $this->core->data['staff_' . $value->code . '_account_id'];
        // if ($this->core->data['staff_' . $value->code . '_account_hraccount_id'] == null) {

            if ($this->core->data['staff_' . $value->code . '_account_id']) {

                DB::table('hr_accounts')
                    ->where(['id' => $this->core->data['staff_' . $value->code . '_account_hraccount_id']])
                    ->update(
                        [
                            'account_id' => intval($this->core->data['staff_' . $value->code . '_account_id']),
                            'account_second_id' => intval($this->core->data['staff_' . $value->code . '' . $value->type . '_second_account_id'])
                        ]
                    );
            }
        // }
        //  else {


        //     DB::table('hr_accounts')
        //         ->where(['id' => $this->core->data['staff_' . $value->code . '_account_hraccount_id']])
        //         ->update([
        //             'account_id' => intval($xe),
        //             'account_second_id' => $re
        //         ]);
        // }
    }

    // public function Account_left($value){


    //     if ($this->core->data['staff_' . $value->code+$value->type . '_account_hraccount_id'] == null) {


    //         if ($this->core->data['staff_' . $value->code+$value->type . '_account_id']) {

    //             // $student = HrAccount::find($this->core->data['staff_' . $value->code+$value->type . '_account_id']);
    //             // $student->name = $this->core->data['staff_' . $value->code+$value->type . '_account_name'];
    //             // $student->code = $value->code;
    //             // $student->account_id = $this->core->data['staff_' . $value->code+$value->type . '_account_id'];
    //             $student->account_second_id = $this->core->data['staff_' . $value->code+$value->type . 'second_account_id'];
    //             // $student->update();
    //         }
    //     } else {

    //         $trimmed = str_replace(
    //             $this->core->data['staff_' . $value->code+$value->type . '_account_id'],
    //             '',
    //             $this->core->data['staff_' . $value->code+$value->type . '_account_name']
    //         );

    //         // dd($request->post('staff_' . $value->code . '_account_name'));
    //         // $student = HrAccount::find($this->core->data['staff_' . $value->code+$value->type . '_account_hraccount_id']);
    //         // $student->name = $trimmed;
    //         // $student->code = $value->code;
    //         // $student->account_id = $this->core->data['staff_' . $value->code+$value->type . '_account_id'];
    //         $student->account_second_id = $this->core->data['staff_' . $value->code+$value->type . 'second_account_id'];
    //         // $student->update();

    //     }

    // }
    public function get_staff_account_setting()
    {



        $accounts = HrAccount::with(
            [
                'account' => function ($query) {
                    $query->select('*', 'text as first_name');
                },
                'account_second' => function ($query) {
                    $query->select('*', 'text as second_name');
                }
            ]
        )->select('hr_accounts.*', 'hr_accounts.name as account_name')
            ->get();

        // dd($accounts);
        $count_account = HrAccount::all()->count();

        return response()->json(['accounts' => $accounts, 'count_account' => $count_account]);
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
