<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use App\Traits\Staff\BasicData\StoreTrait;
use App\Models\VacationType;
use DB;
use Illuminate\Http\Request;

class VacationTypeController extends Controller
{

    use StoreTrait;
    public function index()
    {
        $vacation_types = DB::table('vacation_types')
        ->select('vacation_types.*')
        ->paginate(10);
    return response()->json( ['vacation_types'=>$vacation_types]);
    }


    public function create()
    {
        //
    }


    // public function store(Request $request)
    // {
    //     //
    // }


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
