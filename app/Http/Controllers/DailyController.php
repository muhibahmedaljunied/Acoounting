<?php

namespace App\Http\Controllers;

use App\Daily;
use App\DailyDetail;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Foreach_;

class DailyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json($request->all());


        $daily = new Daily();
        // $daily->daily_id = $request->post('daily_id');
        $daily->daily_date = $request->post('daily_date');
        $daily->total = $request->post('total');
        $daily->save();
        // -------------------------------------------------------------------------------------------------------------------------------------------------------



        for ($i = 1; $i <= $request->post('count'); $i++) {
            

            $dailydetail = new DailyDetail();
            $dailydetail->daily_id = $daily->id;
            $dailydetail->account_id = $request->post('account_id')[$i];
            $dailydetail->account_name =  $request->post('account_name')[$i];
            $dailydetail->description =  $request->post('description')[$i];
            $dailydetail->debit =  $request->post('debit')[$i];
            $dailydetail->credit =  $request->post('credit')[$i];
            $dailydetail->save();




          
        }



        return response()->json($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Daily  $daily
     * @return \Illuminate\Http\Response
     */
    public function show(Daily $daily)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Daily  $daily
     * @return \Illuminate\Http\Response
     */
    public function edit(Daily $daily)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Daily  $daily
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Daily $daily)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Daily  $daily
     * @return \Illuminate\Http\Response
     */
    public function destroy(Daily $daily)
    {
        //
    }
}
