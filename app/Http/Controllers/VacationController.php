<?php

namespace App\Http\Controllers;
use App\Traits\Staff\StoreTrait;
use App\Models\Vacation;
use App\Models\Staff;
use App\Models\Job;
use App\Models\Branch;
use App\Models\StaffType;
use App\Models\VacationType;
use DB;
use Illuminate\Http\Request;

class VacationController extends Controller 
{

    use StoreTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $vacations = staff::with(['vacation','vacation.vacation_type'])->paginate(10);


        // $vacations  = DB::table('vacations')
        // ->join('staff','staff.id', '=', 'vacations.staff_id')
        // ->join('vacation_types','vacation_types.id', '=', 'vacations.vacation_type_id')
        // ->select('vacations.*','staff.name as staff','vacation_types.name as type')
        // ->paginate(10);



        $jobs = Job::all();
        $branches = Branch::all();
        $staff_types = StaffType::all();
        $staffs = Staff::all();
        $vacation_types = VacationType::all();
        return response()->json(['vacations'=>$vacations,'branches'=>$branches,'staff_types'=>$staff_types,'jobs'=>$jobs,'staffs'=>$staffs,'vacation_types'=>$vacation_types]);
    }

   public function select_staff(Request $request){


    $staff_selected = Staff::where([['staff.branch_id', $request->post('branch')],
                             ['staff.staff_type_id',$request->post('staff_type')],
                             ['staff.job_id', $request->post('job')]])
    ->select('staff.name as staff','staff.id as staff_id')
    ->get();
    return response()->json($staff_selected);


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
    // public function store(Request $request)
    // {
    //     $vaction = new Vacation();
    //     $vaction->staff_id = $request->post('name');
    //     $vaction->vacation_type_id  = $request->post('vacation_type');
    //     $vaction->start_date = $request->post('start_date');
    //     $vaction->end_date = $request->post('end_date');
    //     $vaction->total_days = $request->post('days');

    //     $vaction->save();
    //     return response()->json();
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function show(Vacation $vacation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacation $vacation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vacation $vacation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacation $vacation)
    {
        //
    }
}
