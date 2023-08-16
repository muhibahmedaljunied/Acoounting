<?php

namespace App\Http\Controllers\Staff;

use App\Models\Advance;
use App\Models\Staff;
use App\Services\HrService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RepositoryInterface\HRRepositoryInterface;
use App\Services\PayrollService;
use DB;
class AdvanceController extends Controller
{

    public function __construct(
        protected HRRepositoryInterface $hr,
        protected PayrollService $payroll
    ) {

        $this->hr = $hr;
        $this->payroll = $payroll;
    }
    public function index()
    {

        $advances = Staff::with(['advance'])->paginate(10);

        // ---------------------------------
        $this->hr->Sum($advances, 'advance');

        // ------------------------------------------------------------------------------------------------
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });
        // -------------------------------------------------------------------------------------------------

        return response()->json(['staffs' => $staffs, 'list' => $advances]);
    }


    public function select_staff(Request $request)
    {

        $staffs = staff::where('id', $request->id)->with(['advance'])->paginate(10);

        return response()->json(['list' => $staffs]);
    }



    public function store(Request $request)
    {

        foreach ($request->post('count') as $value) {

            $temporale_f = 0;

            // $temporale_f = tap(Advance::whereAdvance($request))
            //     ->update(['quantity' => $request['qty'][$value]])
            //     ->get('id');
            $temporale_f = $this->hr->update($request->all());
            // $this->refresh_payroll($request->all(), $value, $request->post('type'));
            $this->payroll->refresh($request->all(), $value);

            if ($temporale_f->isEmpty()) {

                // $this->add(request:$request->all(), value:$value, type:$request->post('type'));
                $this->hr->add(request: $request->all(), value: $value);
                // $this->refresh_payroll($request->all(), $value, $request->post('type'));
                $this->payroll->refresh($request->all(), $value);
            }
        }




        return response()->json(['message' => $request->all()]);
    }

    public function create()
    {
        //
    }


    public function show(Advance $advance)
    {
        //
    }


    public function edit(Advance $advance)
    {
        //
    }


    public function update(Request $request, Advance $advance)
    {
        //
    }

    public function destroy(Advance $advance)
    {
        //
    }
}
