<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;

use App\Models\DiscountType;
use DB;
use Illuminate\Http\Request;

class DiscountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = DB::table('discounts')
        ->select('discounts.*')
        ->paginate(10);
    return response()->json($discounts);
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
     * @param  \App\DiscountType  $discountType
     * @return \Illuminate\Http\Response
     */
    public function show(DiscountType $discountType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DiscountType  $discountType
     * @return \Illuminate\Http\Response
     */
    public function edit(DiscountType $discountType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DiscountType  $discountType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DiscountType $discountType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DiscountType  $discountType
     * @return \Illuminate\Http\Response
     */
    public function destroy(DiscountType $discountType)
    {
        //
    }
}
