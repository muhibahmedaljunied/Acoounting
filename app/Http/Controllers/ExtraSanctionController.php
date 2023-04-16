<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\ExtraType;
use App\Models\ExtraPart;
use App\Models\Staff;
use App\Models\SanctionDiscount;
use App\Traits\Staff\StoreTrait;
use DB;
use Illuminate\Http\Request;

class ExtraSanctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use StoreTrait;
    public function index()
    {

        $extra_sanctions = DB::table('extra_sanctions')
        ->join('staff','staff.id', '=', 'extra_sanctions.staff_id')
        ->join('extra_types','extra_types.id', '=', 'extra_sanctions.extra_type_id')
        ->join('extra_parts','extra_parts.id', '=', 'extra_sanctions.extra_type_id')
        ->join('sanction_discounts','sanction_discounts.id', '=', 'extra_sanctions.sanction_discount_id')
        ->select('staff.name as staff_name','extra_sanctions.*','extra_parts.name as duration','extra_types.name as extra','sanction_discounts.name as discount_name')
        ->paginate(10);

        
        // $extra_sanctions = DB::table('absence_sanctions')
        // ->join('staff','staff.id', '=', 'absence_sanctions.staff_id')
        // ->join('absence_types','absence_types.id', '=', 'absence_sanctions.absence_type_id')
        // ->join('sanction_discounts','sanction_discounts.id', '=', 'absence_sanctions.sanction_discount_id')
        // ->select('staff.name as staff_name','absence_sanctions.*','absence_types.name as absence','sanction_discounts.name as discount_name')
        // ->paginate(10);


        $extra_types = ExtraType::all();
        $discount_types = SanctionDiscount::all();

        $extra_parts = ExtraPart::all();
        $staffs = Staff::all();

        return response()->json(['list'=>$extra_sanctions,'extra_types'=>$extra_types,'staffs'=>$staffs,'discount_types'=>$discount_types,'extra_parts'=>$extra_parts]);
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


  
    public function show(Extra $absence)
    {
        //
    }


    public function edit(Extra $absence)
    {
        //
    }

 
    public function update(Request $request, Extra $absence)
    {
        //
    }


    public function destroy(Extra $absence)
    {
        //
    }
}
