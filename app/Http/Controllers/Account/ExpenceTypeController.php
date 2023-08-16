<?php

namespace App\Http\Controllers\Account;

use App\Models\ExpenceType;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ExpenceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expences = DB::table('expence_types')
        ->select('expence_types.*')
        ->paginate(10);
    return response()->json($expences);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExpenceType  $ExpenceType
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenceType $ExpenceType)
    {
        $expence_types = ExpenceType::all();
      
        return response()->json(['expence_types'=>$expence_types]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExpenceType  $ExpenceType
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenceType $ExpenceType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExpenceType  $ExpenceType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenceType $ExpenceType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenceType  $ExpenceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenceType $ExpenceType)
    {
        //
    }
}
