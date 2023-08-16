<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use App\Services\HrService;
use App\RepositoryInterface\HRRepositoryInterface;
use App\Models\Vacation;
use App\Models\Staff;

use App\Models\Branch;
use App\Models\StaffType;
use App\Models\VacationType;
use App\Services\PayrollService;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class VacationController extends Controller
{

    // use StoreTrait;

    public function __construct(
        protected HRRepositoryInterface $hr
        )
    {
        
        $this->hr = $hr;
   
    
    }

    public function index()
    {


        $vacations = staff::with(['vacation', 'vacation.vacation_type'])->paginate(10);
        $this->hr->Sum($vacations, 'vaction');

        $branches = Branch::all();
        $staff_types = StaffType::all();
        // ------------------------------------------------------------------------------------------------
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });
        // --------------------------------------------------------------------------------------------------


        $vacation_types = VacationType::all();
        return response()->json(['list' => $vacations, 'branches' => $branches, 'staff_types' => $staff_types, 'staffs' => $staffs, 'vacation_types' => $vacation_types]);
    }

    public function select_staff(Request $request)
    {

        $staffs = staff::where('id', $request->id)->with(['vacation', 'vacation.vacation_type'])->paginate(10);
        return response()->json(['list' => $staffs]);
    }

    public function store(Request $request,PayrollService $payroll)
    {

        foreach ($request->post('count') as $value) {


            $temporale_f = 0;

            // $temporale_f = tap(Vacation::whereLeave($request))
            //     ->update(['total_days' => $request['days']])
            //     ->get('id');

            $temporale_f = $this->hr->update($request->all());

            if ($temporale_f->isEmpty()) {

                $this->hr->add(request: $request->all(), value: $value, type: $request->post('type'));
                // $this->refresh_payroll($request->all(), $value, $request->post('type'));
                $payroll->refresh($request->all(), $value);

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
    public function show(Vacation $vacation)
    {
        //
    }

    
    public function edit(Vacation $vacation)
    {
        //
    }

    
    public function update(Request $request, Vacation $vacation)
    {
        //
    }

        public function destroy(Vacation $vacation)
    {
        //
    }
}
