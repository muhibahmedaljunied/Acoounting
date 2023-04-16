<?php

namespace App\Http\Controllers;

use App\Models\IncomeType;
use DB;
use Illuminate\Http\Request;

class IncomeTypeController extends Controller
{
   
    public function index()
    {
        $incomes = DB::table('incomes')
        ->select('incomes.*')
        ->paginate(10);
    return response()->json($incomes);
    }

  
    public function create()
    {
        //
    }

 
    public function store(Request $request)
    {
        //
    }

   
    public function show()
    {
        //
    }

  
    public function edit()
    {
        //
    }

   
    public function update()
    {
        //
    }

    public function destroy()
    {
        //
    }
}
