<?php

namespace App\Http\Controllers;
// use App\Traits\Staff\StoreTrait;
use App\Models\Advance;
use App\Models\Staff;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class AdvanceController extends Controller
{
//    use StoreTrait;
    public function index()
    {

        $advances = Staff::with(['advance'])->paginate(10);
        // $staffs = Staff::all();
        // ------------------------------------------------------------------------------------------------
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });
        // -------------------------------------------------------------------------------------------------

        return response()->json(['staffs'=>$staffs,'list'=>$advances]);
    }

    public function select_staff(Request $request){

        $staffs = staff::where('id', $request->id)->with(['advance'])->paginate(10);

        return response()->json(['list'=>$staffs]);
    
    
        }



        public function store(Request $request)
        {
    
            foreach ($request->post('count') as $value) {
    
    
                // return response()->json(['message' => $request->all()]);
                $temporale_f = 0;
    
                if ($request->post('type') == 'advance') {
    
                    $temporale_f = tap(Advance::whereAdvance($request))
                        ->update(['quantity' => $request['qty'][$value]])
                        ->get('id');
                    $this->refresh_payroll($request->all(), $value, $request->post('type'));
                }
    
                if ($temporale_f->isEmpty()) {
    
                    $this->add($request->all(), $value, $request->post('type'));
                    $this->refresh_payroll($request->all(), $value, $request->post('type'));
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
