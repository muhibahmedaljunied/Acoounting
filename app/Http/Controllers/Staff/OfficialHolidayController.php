<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use App\Models\VacationType;
use DB;
use Illuminate\Http\Request;

class OfficialHolidayController extends Controller
{

    public function index()
    {
        $official_holidays = DB::table('official_holidays')
        ->select('official_holidays.*')
        ->paginate(10);
    return response()->json( ['official_holidays'=>$official_holidays]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(VacationType $vacationType)
    {
        //
    }

    public function edit(VacationType $vacationType)
    {
        //
    }

  
    public function update(Request $request, VacationType $vacationType)
    {
        //
    }

 
    public function destroy(VacationType $vacationType)
    {
        //
    }
}
