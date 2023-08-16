<?php

namespace App\Http\Controllers\Leave;
use App\Services\SanctionService;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Part;
use App\Models\Staff;
use App\Models\SanctionDiscount;
use App\Models\LeaveSanction;
use App\Http\Controllers\Controller;
use App\RepositoryInterface\SingleSanctionRepositoryInterface;
// use App\Traits\Staff\StoreTrait;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class LeaveSanctionController extends Controller
{
    
    // use StoreTrait;
    public function index()
    {

        $leave_sanctions = Cache::rememberForever('leave_sanctions_index', function () {

            return DB::table('leave_sanctions')
                ->join('leave_types', 'leave_types.id', '=', 'leave_sanctions.leave_type_id')
                // ->join('leave_parts', 'leave_parts.id', '=', 'leave_sanctions.leave_part_id')
                ->join('parts','parts.id', '=', 'leave_sanctions.part_id')
                ->join('sanction_discounts', 'sanction_discounts.id', '=', 'leave_sanctions.sanction_discount_id')
                ->select('leave_sanctions.*', 'leave_types.name as leave', 'parts.name as duration', 'sanction_discounts.name as discount_name')
                ->paginate(10);
        });

        $leave_types = LeaveType::all();
        $leave_parts = Part::all();
        $discount_types = SanctionDiscount::all();
        // ------------------------------------------------------------------------------------------------
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });
        // --------------------------------------------------------------------------------------------------

        return response()->json(['list' => $leave_sanctions, 'leave_types' => $leave_types, 'staffs' => $staffs, 'discount_types' => $discount_types, 'leave_parts' => $leave_parts]);
    }

    public function store(Request $request,SingleSanctionRepositoryInterface $sanction)
    {

        foreach ($request->post('count') as $value) {


            // return response()->json(['message' => $request->all()]);
            $temporale_f = 0;
            $temporale_f = $sanction->update($temporale_f,$request,$request->post('type'));

            if ($temporale_f->isEmpty()) {

                $sanction->add($request->all(),$value);
         
            }
        }
        Cache::forget('leave_sanctions_index');

        return response()->json(['message' => $request->all()]);
    }

   
    public function create()
    {
        //
    }




    public function show()
    {
        //
    }


    public function edit()
    {
        //
    }


    public function update(Request $request)
    {
        //
    }


    public function destroy()
    {
        //
    }
}
