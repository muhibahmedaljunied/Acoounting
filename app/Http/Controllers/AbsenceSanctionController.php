<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\AbsenceType;
use App\Models\SanctionDiscount;
use App\Models\AbsenceSanction;
use Illuminate\Support\Facades\Cache;
use DB;
use Illuminate\Http\Request;

class AbsenceSanctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   
    public function index()
    {


        $absence_sanctions = Cache::rememberForever('absence_sanctions_index', function () {

            return DB::table('absence_sanctions')
                ->join('staff', 'staff.id', '=', 'absence_sanctions.staff_id')
                ->join('absence_types', 'absence_types.id', '=', 'absence_sanctions.absence_type_id')
                ->join('sanction_discounts', 'sanction_discounts.id', '=', 'absence_sanctions.sanction_discount_id')
                ->select('staff.name as staff_name', 'absence_sanctions.*', 'absence_types.name as absence', 'sanction_discounts.name as discount_name')
                ->paginate(10);
        });



        $absence_types = AbsenceType::all();
        $discount_types = SanctionDiscount::all();
        // ------------------------------------------------------------------------------------------------
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });
        // --------------------------------------------------------------------------------------------------


        return response()->json(['absence_types' => $absence_types, 'staffs' => $staffs, 'discount_types' => $discount_types, 'list' => $absence_sanctions]);
    }

    public function store(Request $request)
    {

        foreach ($request->post('count') as $value) {


            $temporale_f = 0;

            if ($request->post('type') == 'absence_sanction') {

                $temporale_f = tap(AbsenceSanction::whereAbsenceSanction($request))
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





    public function show(Absence $absence)
    {
        //
    }


    public function edit(Absence $absence)
    {
        //
    }


    public function update(Request $request, Absence $absence)
    {
        //
    }


    public function destroy(Absence $absence)
    {
        //
    }
}
