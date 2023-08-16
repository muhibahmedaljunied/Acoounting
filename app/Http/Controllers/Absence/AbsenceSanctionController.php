<?php

namespace App\Http\Controllers\Absence;

use Illuminate\Pipeline\Pipeline;
use App\Models\Absence;
use App\Models\AbsenceType;
use App\Models\SanctionDiscount;
use App\Models\AbsenceSanction;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

use App\RepositoryInterface\SingleSanctionRepositoryInterface;
use DB;
use Illuminate\Http\Request;

class AbsenceSanctionController extends Controller
{



    public function index()
    {
       

        $absence_sanctions = Cache::rememberForever('absence_sanctions_index', function () {

            return DB::table('absence_sanctions')
                ->join('absence_types', 'absence_types.id', '=', 'absence_sanctions.absence_type_id')
                ->join('sanction_discounts', 'sanction_discounts.id', '=', 'absence_sanctions.sanction_discount_id')
                ->select('absence_sanctions.*', 'absence_types.name as absence', 'sanction_discounts.name as discount_name')
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

    public function store(Request $request,SingleSanctionRepositoryInterface $sanction)
    {

        foreach ($request->post('count') as $value) {


            $temporale_f = 0;
            $temporale_f = $sanction->update($temporale_f,$request);
            if ($temporale_f->isEmpty()) {

                $sanction->add($request,$value);
    
            }
        }

        Cache::forget('absence_sanctions_index');



        return response()->json(['message' => $request->all()]);
    }


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
