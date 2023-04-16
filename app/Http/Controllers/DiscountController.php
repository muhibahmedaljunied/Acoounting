<?php

namespace App\Http\Controllers;

use App\Traits\Staff\StoreTrait;
// use Illuminate\Foundation\Auth\Access\Staff as s;
use App\Models\Discount;
use App\Models\Staff;
use App\Models\DiscountType;
use DB;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    
    use StoreTrait;
    public function index()
    {

        $discounts = staff::with(['discount','discount.discount_type'])->paginate(10);


        // 
        // $discounts = Staff::with('discounts')
        //     ->paginate(10);

        // $discounts = DB::table('discounts')
        // ->join('discount_types','discount_types.id', '=', 'discounts.discount_type_id')
        // ->join('staff','staff.id', '=', 'discounts.staff_id')
        // ->select('discounts.*','discount_types.name as discount','staff.*')
        // ->paginate(10);

        $discount_types = DiscountType::all();
        $staffs = Staff::all();
        return response()->json(['discount_types' => $discount_types, 'staffs' => $staffs, 'list' => $discounts]);
    }

    public function select_staff(Request $request){

        $staffs = staff::where('id', $request->id)->with(['discount','discount.discount_type'])->paginate(10);

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

    

    public function show(Discount $discount)
    {
        //
    }

    
    public function edit(Discount $discount)
    {
        //
    }

    
    public function update(Request $request, Discount $discount)
    {
        //
    }

   
    public function destroy(Discount $discount)
    {
        //
    }
}
