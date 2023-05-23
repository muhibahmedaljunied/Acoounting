<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\LeavePart;
use App\Models\Staff;
use App\Models\SanctionDiscount;
use App\Models\LeaveSanction;
// use App\Traits\Staff\StoreTrait;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class LeaveSanctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // use StoreTrait;
    public function index()
    {

        $leave_sanctions = Cache::rememberForever('leave_sanctions_index', function () {

            return DB::table('leave_sanctions')
                ->join('staff', 'staff.id', '=', 'leave_sanctions.staff_id')
                ->join('leave_types', 'leave_types.id', '=', 'leave_sanctions.leave_type_id')
                ->join('leave_parts', 'leave_parts.id', '=', 'leave_sanctions.leave_part_id')
                ->join('sanction_discounts', 'sanction_discounts.id', '=', 'leave_sanctions.sanction_discount_id')
                ->select('staff.name as staff_name', 'leave_sanctions.*', 'leave_types.name as leave', 'leave_parts.name as duration', 'sanction_discounts.name as discount_name')
                ->paginate(10);
        });



        $leave_types = LeaveType::all();
        $leave_parts = LeavePart::all();
        $discount_types = SanctionDiscount::all();
        // ------------------------------------------------------------------------------------------------
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });
        // --------------------------------------------------------------------------------------------------

        return response()->json(['list' => $leave_sanctions, 'leave_types' => $leave_types, 'staffs' => $staffs, 'discount_types' => $discount_types, 'leave_parts' => $leave_parts]);
    }

    public function store(Request $request)
    {

        foreach ($request->post('count') as $value) {


            // return response()->json(['message' => $request->all()]);
            $temporale_f = 0;


            if ($request->post('type') == 'leave_sanction') {

                $temporale_f = tap(LeaveSanction::whereLeaveSanction($value))
                    ->update(['sanctions' => $request['sanction']])
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




    public function show(Leave $absence)
    {
        //
    }


    public function edit(Leave $absence)
    {
        //
    }


    public function update(Request $request, Leave $absence)
    {
        //
    }


    public function destroy(Leave $absence)
    {
        //
    }
}
