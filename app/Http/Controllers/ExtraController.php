<?php

namespace App\Http\Controllers;

// use App\Traits\Staff\StoreTrait;
// use Illuminate\Foundation\Auth\Access\Staff as s;
use App\Models\Extra;
use App\Models\ExtraType;
use App\Models\ExtraPart;
use App\Models\Staff;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class ExtraController extends Controller
{
    // use StoreTrait;
    public function index()
    {

        $extras = staff::with(['extra', 'extra.extra_type'])->paginate(10);

        $extra_parts = ExtraPart::all();
        $extra_types = ExtraType::all();
        // -------------------
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });
        $re =Cache::get('staff');
        // -------------------
        
        return response()->json(['re' => $re,'extra_types' => $extra_types, 'extra_parts' => $extra_parts, 'staffs' => $staffs, 'list' => $extras]);
    }


    public function select_staff(Request $request)
    {

        $staffs = staff::where('id', $request->id)->with(['extra', 'extra.extra_type'])->paginate(10);

        return response()->json(['list' => $staffs]);
    }

    public function store(Request $request)
    {

        foreach ($request->post('count') as $value) {

            // return response()->json(['message' => $request->all()]);

            $temporale_f = 0;
            $temporale_f = tap(Extra::whereExtra($request))
                ->update([
                    'date' => $request['date'][$value],
                    'start_time' => $request['start_time'][$value],
                    'end_time' => $request['end_time'][$value],
                    'number_hours' => $request['duration'][$value]
                ])
                ->get('id');

            if ($temporale_f->isEmpty()) {

                $we = $this->add($request->all(), $value, $request->post('type'));
                // $this->refresh_payroll($request->all(), $value, $request->post('type'));
            }
        }




        return response()->json(['message' => $we]);
    }

    public function create(Request $request)
    {
    }


    public function show(Extra $extra)
    {
        //
    }


    public function edit(Extra $extra)
    {
        //
    }

    public function update(Request $request, Extra $extra)
    {
        //
    }


    public function destroy(Extra $extra)
    {
        //
    }
}
