<?php

namespace App\Http\Controllers\Staff;
use App\Services\HrService;
use App\Http\Controllers\Controller;

use App\RepositoryInterface\HRRepositoryInterface;
use App\RepositoryInterface\PayrollRepositoryInterface;
use App\Services\PayrollService;
use App\Models\Discount;
use App\Models\Staff;
use App\Models\DiscountType;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    
 
    public function __construct(
        protected HRRepositoryInterface $hr,
        protected PayrollRepositoryInterface $payroll)
    {
        
        $this->hr = $hr;
        $this->payroll = $payroll;
    
    }


    public function index(HrService $hr)
    {

        $discounts = staff::with(['discount','discount.discount_type'])->paginate(10);

        $this->hr->Sum($discounts,'discount');
        $discount_types = DiscountType::all();
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
            $temporale_f = $this->hr->update($request->all());
            $this->payroll->refresh($request->all(), $value);
        

            if ($temporale_f->isEmpty()) {

                // $this->add(request:$request->all(), value:$value, type:$request->post('type'));
                $this->hr->add(request:$request->all(), value:$value);
                $this->payroll->refresh($request->all(), $value);
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
