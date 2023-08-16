<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use App\Models\Loan;
use App\Models\Staff;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $loans = DB::table('loans')
        ->join('staff','staff.id', '=', 'loans.staff_id')
        ->select('staff.name as staff','loans.*')
        ->paginate(10);
        // $staffs = Staff::all();
         // ------------------------------------------------------------------------------------------------
         $minutes = 60;
         $staffs = Cache::remember('staff', $minutes, function () {
             return DB::table('staff')->get();
         });
         // --------------------------------------------------------------------------------------------------
        
        return response()->json(['staffs'=>$staffs,'loans'=>$loans]);
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
        $loans = new Loan();
        $loans->staff_id = $request->post('staff');
        $loans->date = $request->post('date');
        $loans->quantity = $request->post('quantity');
        $loans->number_premium = $request->post('number_premium');
        $loans->premium = $request->post('premium');
        $loans->note = $request->post('note');

        $loans->save();
        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        //
    }
}
