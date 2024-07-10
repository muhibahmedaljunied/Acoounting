<?php

namespace App\Http\Controllers\Extra;
use App\Http\Controllers\Controller;
use App\Services\Staff\ExtraService;
use Illuminate\Support\Facades\Cache;
use App\Repository\HR\ExtraRepository;
use App\Services\CoreStaffService;
use App\Models\ExtraType;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class ExtraController extends Controller
{

    public function __construct(

     
        protected CoreStaffService $core,
        protected ExtraService $extra_sanction,
        protected ExtraRepository $hr,



    ) {
    }

    public function index()
    {


        $extras = staff::with(['extra', 'extra.extra_type'])->paginate(10);
        $this->hr->Sum($extras, 'extra');

        // dd($extras);
        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });

        return response()->json([
            'extra_types' => ExtraType::all(),
            // 'extra_parts' => ExtraPart::all(),
            'staffs' => Staff::all(),
            'list' => $extras
        ]);
    }


    public function select_staff(Request $request)
    {

        $staffs = staff::where('id', $request->id)->with(['extra', 'extra.extra_type'])->paginate(10);

        return response()->json(['list' => $staffs]);
    }

    public function report(Request $request){

        
        $extras = Staff::with(['extra' => function ($query) use ($request) {
            $query->select('extras.*')
            ->where('extras.staff_id','=', $request->staff)
            ->whereBetween('extras.date', array($request->post('from_date'), $request->post('into_date')));

        }])
        ->select('*')
        ->paginate(10);
        // dd($advances);
        $this->hr->Sum($extras);

        // dd($advances);
        return response()->json(['list' => $extras]);


    }

    public function store(Request $request)
    {


        // dd($request->all());
        $this->core->data = $request->all();

        try {

            DB::beginTransaction();
            foreach ($request->post('count') as $value) {

                $this->core->setValue($value);
                $this->init_data_store();
                $this->hr->store();
                $this->extra_sanction->create();
            }

            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "Extra Created Successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }
        // return response()->json(['message' => $we]);
    }


    public function destroy($id)
    {

        // DB::table('payrolls')->where('staff_id', '=', $id)->delete();

        // $store = staff::find($id);

        // $store->delete();

        // Cache::forget('staff');



        return response()->json('successfully deleted');
    }

    public function init_data_store()
    {

        $this->hr->staff_id = $this->core->data['staff'][$this->core->value];
        $this->hr->extra_type_id = $this->core->data['extra_type'][$this->core->value];
        $this->hr->date = $this->core->data['date'][$this->core->value];
        $this->hr->start_time = $this->core->data['start_time'][$this->core->value]; 
        $this->hr->end_time = $this->core->data['end_time'][$this->core->value];
        $this->hr->number_hours = $this->core->data['duration'][$this->core->value][0];

    }
}
