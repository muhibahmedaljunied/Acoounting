<?php

namespace App\Http\Controllers;

// use App\Traits\Staff\StoreTrait;
// use Illuminate\Foundation\Auth\Access\Staff as s;
use App\Models\Discount;
use App\Models\Staff;
use App\Models\DiscountType;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    
    // use StoreTrait;
    public function index()
    {

        $discounts = staff::with(['discount','discount.discount_type'])->paginate(10);


        $discount_types = DiscountType::all();
        // $staffs = Staff::all();
        // ------------------------------------------------------------------------------------------------
        $minutes = 60;
        $staffs = Cache::remember('staff', $minutes, function () {
            return DB::table('staff')->get();
        });
        // -------------------------------------------------------------------------------------------------

        return response()->json(['discount_types' => $discount_types, 'staffs' => $staffs, 'list' => $discounts]);
    }

    public function select_staff(Request $request){

        $staffs = staff::where('id', $request->id)->with(['discount','discount.discount_type'])->paginate(10);

        return response()->json(['list'=>$staffs]);
    
    
        }

        public function store(Request $request)
    {

        foreach ($request->post('count') as $value) {


            $temporale_f = 0;

                // return response()->json(['message' => $request->all()]);
            $temporale_f = tap(Discount::whereDiscount($request))
                ->update(['quantity' => $request['qty'][$value]])
                ->get('id');
            $this->refresh_payroll($request->all(), $value, $request->post('type'));
        

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
