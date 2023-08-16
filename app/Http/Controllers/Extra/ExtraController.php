<?php

namespace App\Http\Controllers\Extra;

use App\RepositoryInterface\HRRepositoryInterface;
use App\Services\HrService;
use App\Models\Extra;
use App\Models\ExtraType;
use App\Models\ExtraPart;
use App\Models\Staff;
use App\Services\SanctionService;

use App\Http\Controllers\Controller;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Services\ExtraService;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class ExtraController extends Controller
{

    public function __construct(
        protected HRRepositoryInterface $hr,
        protected DetailRepositoryInterface $details,
        protected ExtraService $extra

    ) {

        $this->hr = $hr;
        $this->details = $details;
        $this->extra = $extra;
    }

    public function index()
    {

        $extras = staff::with(['extra', 'extra.extra_type'])->paginate(10);
        $this->hr->Sum($extras, 'extra');

        $extra_parts = ExtraPart::all();
        $extra_types = ExtraType::all();

        $staffs = Cache::rememberForever('staff', function () {
            return DB::table('staff')->get();
        });

        return response()->json([
            'extra_types' => $extra_types,
            'extra_parts' => $extra_parts,
            'staffs' => $staffs,
            'list' => $extras
        ]);
    }


    public function select_staff(Request $request)
    {

        $staffs = staff::where('id', $request->id)->with(['extra', 'extra.extra_type'])->paginate(10);

        return response()->json(['list' => $staffs]);
    }

    public function store(Request $request, HrService $hr)
    {
        //   return response()->json(['message' => $request->all()]);

        try {

            DB::beginTransaction();
            foreach ($request->post('count') as $value) {
                $temporale_f = 0;
                // $temporale_f = $hr->refresh($request->all(), $value, $request->post('type'));
                $temporale_f = $this->hr->update($request->all(), $value);

                if ($temporale_f->isEmpty()) {

                    $id = $this->hr->add(request: $request->all(), value: $value);
                    $this->extra->create($id, $request->all(), $value);

                }
            }

            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "purchase created successfully",
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






    public function edit()
    {
        //
    }




    public function destroy(Extra $extra)
    {
        //
    }
}
