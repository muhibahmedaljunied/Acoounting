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
use Illuminate\Support\Facades\Cache;
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

        $branches = Branch::all();
        $staff_types = StaffType::all();
        // $staffs = Staff::all();
         // ------------------------------------------------------------------------------------------------
         $staffs = Cache::rememberForever('staff', function () {
             return DB::table('staff')->get();
         });
         // --------------------------------------------------------------------------------------------------
        

        $vacation_types = VacationType::all();
        return response()->json(['list'=>$vacations,'branches'=>$branches,'staff_types'=>$staff_types,'staffs'=>$staffs,'vacation_types'=>$vacation_types]);
    }

   public function select_staff(Request $request){

    $staffs = staff::where('id', $request->id)->with(['vacation','vacation.vacation_type'])->paginate(10);
    return response()->json(['list'=>$staffs]);


    }

    public function store(Request $request)
    {

        foreach ($request->post('count') as $value) {


            // return response()->json(['message' => $request->all()]);
            $temporale_f = 0;


            if ($request->post('type') == 'leave') {


                $temporale_f = tap(Vacation::whereLeave($request))
                    ->update(['total_days' => $request['days']])
                    ->get('id');
            }

            if ($temporale_f->isEmpty()) {



                $this->add($request->all(), $value, $request->post('type'));
                $this->refresh_payroll($request->all(), $value, $request->post('type'));
            }
        }




        return response()->json(['message' => $request->all()]);
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
