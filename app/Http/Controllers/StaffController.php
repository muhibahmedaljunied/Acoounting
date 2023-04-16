<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Staff;
use App\Models\Job;
use App\Models\AdministrativeStructure;
use App\Models\Qualification;
use App\Models\Nationality;
use App\Models\StaffType;
use App\Models\StaffReligion;
use App\Models\Department;
use App\Models\Payroll;
use App\Models\WorkType;
use DB;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        
        $staff_list =  staff::with([
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
            'work_type' => function ($query) {
                $query->select('*');
            },
            'staff_religion' => function ($query) {
                $query->select('*');
            },
            'nationality' => function ($query) {
                $query->select('*');
            }

        ])
            ->paginate(10);


        // $staff_list = DB::table('staff')
        // ->join('qualifications','qualifications.id', '=', 'staff.qualification_id')
        // ->join('branches','branches.id', '=', 'staff.branch_id')
        // ->join('administrative_structures','administrative_structures.id', '=', 'staff.department_id')
        // // ->join('administrative_structures','administrative_structures.id', '=', 'staff.job_id')
        // ->join('staff_types','staff_types.id', '=', 'staff.staff_type_id')
        // ->join('work_types','work_types.id', '=', 'staff.work_type_id')
        // ->join('staff_religions','staff_religions.id', '=', 'staff.religion_id')
        // ->join('nationalities','nationalities.id', '=', 'staff.nationality_id')
        // ->select(
        //     'staff.id','staff.email','staff.date','staff.name as staff',
        //     'staff.staff_status as status','staff.gender','staff.social_status',
        //     'staff.personal_card','staff.phone','staff.barth_date','work_types.name as work_type',
        //     'qualifications.name as qualification','branches.name  as branch',
        //     'administrative_structures.text as department','administrative_structures.text  as job',
        //     'staff_types.name as staff_types','staff_religions.name as religion','nationalities.name as nationality')
        // ->paginate(10);

        $staffs = Staff::all();
        $work_systems = WorkType::all();
        $qualifications = Qualification::all();
        $nationalities = Nationality::all();
        $staff_types = StaffType::all();
        $staff_religions = StaffReligion::all();
        $branches = Branch::all();
        return response()->json(['qualifications'=>$qualifications,'nationalities'=>$nationalities,
                                 'staff_types'=>$staff_types,'staff_religions'=>$staff_religions,'list'=>$staff_list,
                                  'branches'=>$branches,'staffs'=>$staffs,'work_systems'=>$work_systems]);
    }

    public function get_job(Request $request)
    {


        $jobs = AdministrativeStructure::where('administrative_structures.parent_id', $request->id)
            ->select('administrative_structures.*')
            ->get();

        return response()->json(['jobs' => $jobs]);
    }




    public function select_staff(Request $request){

        $staffs = DB::table('staff')
        ->where('staff.id', $request->id)
        ->join('qualifications','qualifications.id', '=', 'staff.qualification_id')
        ->join('branches','branches.id', '=', 'staff.branch_id')
        ->join('departments','departments.id', '=', 'staff.department_id')
        ->join('jobs','jobs.id', '=', 'staff.job_id')
        ->join('staff_types','staff_types.id', '=', 'staff.staff_type_id')
        ->join('staff_religions','staff_religions.id', '=', 'staff.religion_id')
        ->join('nationalities','nationalities.id', '=', 'staff.nationality_id')
        ->select('staff.id','staff.email','staff.date','staff.name as staff','staff.staff_status as status','staff.gender','staff.social_status','qualifications.name as qualification','branches.name  as branch','departments.name as department','jobs.name  as job','staff_types.name as staff_types','staff_religions.name as religion','nationalities.name as nationality')
        ->paginate(10);

        return response()->json(['list'=>$staffs]);
    
    
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        $staff->work_type_id = $request->post('work');
        // $staff->salary= 1;
        // $staff->register= $request->post('register');
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
        $staff->salary = $request->post('salary');
        $staff->save();

        //----------------------------------------------------------------------------------------------- 
        $payroll = new Payroll();
        $payroll->staff_id = $staff->id;
        $payroll->net_salary = $request->post('salary');
        $payroll->save();

      


        return response()->json($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
       

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        //
    }
}
