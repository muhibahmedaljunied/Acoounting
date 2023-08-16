<?php

namespace App\Http\Controllers\Warehouse;


use App\Models\Unit;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $units = Unit::all();
        return response()->json(['units'=>$units]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $unit = new Unit();
    //     $unit->name = $request->post('unit');
    //     $unit->save();
    //     return response()->json();
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $units = Unit::where('product_units.product_id',$request->id)
            ->join('product_units', 'units.id', '=', 'product_units.unit_id')
            ->join('products', 'product_units.product_id', '=', 'products.id')
            ->select('units.*','product_units.unit_type','products.rate')
            ->get();


        return response()->json(['units'=>$units]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Absence $absence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absence $absence)
    {
        //
    }
}
