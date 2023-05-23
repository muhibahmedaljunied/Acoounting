<?php

namespace App\Http\Controllers;


use App\Traits\Staff\BasicData\StoreTrait;

use App\Models\AllowanceType;

use DB;
use Illuminate\Http\Request;

class AllowanceTypeController extends Controller
{

    use StoreTrait;
    public function index()
    {


        $allowance_types = AllowanceType::all();
        return response()->json(['allowance_types' => $allowance_types]);
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



    public function show(AllowanceType $allowance)
    {
        //
    }


    public function edit(AllowanceType $allowance)
    {
        //
    }


    public function update(AllowanceType $allowance)
    {
        //
    }


    public function destroy(AllowanceType $allowance)
    {
        //
    }
}
