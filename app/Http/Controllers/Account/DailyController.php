<?php

namespace App\Http\Controllers\Account;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\DailyService;
use Illuminate\Support\Facades\DB;
use App\Models\Account;

class DailyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(
        // protected DailyService $service
    )
    {

        // $this->service = $service;
    }
    public function index()
    {


        $sum_debit = 0;
        $sum_credit = 0;

        $daily_details =  Account::join('daily_details', 'daily_details.account_id', '=', 'accounts.id')
            ->select('accounts.*', 'daily_details.*')
            ->paginate(100);

        foreach ($daily_details as $value) {

            $sum_debit += $value->debit;
            $sum_credit += $value->credit;
        }

        // dd($daily_details->sum_credit);
        return response()->json([
            'daily_details' => $daily_details, 
            'sum_debit' => $sum_debit,
            'sum_credit' => $sum_credit
        ]);
    }

    public function account_report(Request $request)
    {

        $sum_debit = 0;
        $sum_credit = 0;
        $account_details =  Account::join('daily_details', 'daily_details.account_id', '=', 'accounts.id')
            ->where('daily_details.account_id', $request->id)
            ->select('accounts.*', 'daily_details.*')
            ->paginate(100);

        foreach ($account_details as $value) {

            $sum_debit += $value->debit;
            $sum_credit += $value->credit;
        }


        // dd($account_details->sum_credit);
        return response()->json([
            'account_details' => $account_details,
            'sum_debit' => $sum_debit,
            'sum_credit' => $sum_credit
        ]);
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



        // $this->service->data_store = $request;

        // $this->service->handle();



        return response()->json($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Daily  $daily
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
        $sum_debit = 0;
        $sum_credit = 0;

        $daily_details =  Account::join('daily_details', 'daily_details.account_id', '=', 'accounts.id')
        ->where('daily_id',$request->id)
            ->select('accounts.*', 'daily_details.*')
            ->paginate(100);

        foreach ($daily_details as $value) {

            $sum_debit += $value->debit;
            $sum_credit += $value->credit;
        }

        // dd($daily_details->sum_credit);
        return response()->json([
            'daily_details' => $daily_details, 
            'sum_debit' => $sum_debit,
            'sum_credit' => $sum_credit
        ]);

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
