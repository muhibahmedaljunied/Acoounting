<?php

namespace App\Http\Controllers\Warehouse;

use App\Models\Absence;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        
    }

    
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {

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
