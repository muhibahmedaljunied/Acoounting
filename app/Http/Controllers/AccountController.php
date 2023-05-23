<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\DailyDetail;
use Illuminate\Http\Request;
use Storage;
use DB;

use function PHPSTORM_META\type;

class AccountController extends Controller
{


    public function index()
    {
    }

 
    public function create()
    {
    }



    public function get_account_name(Request $request)
    {

        $accounts =  DailyDetail::where('daily_details.account_id', $request->id)
            ->select('daily_details.account_name')
            ->get();
        return response()->json(['accounts' => $accounts]);
    }

    public function auditBalance()
    {


        // $auditBalances = DB::table('daily_details ')
        // ->select('daily_details.account_name', DB::raw('SUM(daily_details.debit) as debit','SUM(daily_details.credit) as credit'))       
        // ->get();


        $auditBalances = DB::table('daily_details')
            ->select('daily_details.account_name', DB::raw('SUM(daily_details.debit) as debit'), DB::raw('SUM(daily_details.debit)-SUM(daily_details.credit) as s'), DB::raw('SUM(daily_details.credit)-SUM(daily_details.debit) as s1'), DB::raw('SUM(daily_details.credit) as credit'))
            ->groupBy('daily_details.account_name')
            ->get();

        return response()->json(['auditBalances' => $auditBalances]);
    }

    public function AccountStatement(Request $request)
    {


        $daily_details =  DailyDetail::where('daily_details.account_id', $request->id)
            ->join('dailies', 'dailies.id', '=', 'daily_details.daily_id')
            ->select('dailies.daily_date', 'daily_details.*')
            ->get();
        return response()->json(['daily_details' => $daily_details]);
    }

   

    // public function store_first_level(Request $request){


    //     $product = new Account();
    //     $product->text = $request->post('text');
    //     if($request->post('parent') != 0){
    //         $product->parent_id= $request->post('parent');
    //     }
    //     $product->id = $request->post('id');
    //     $product->rank = $request->post('rank');
    //     $product->save();

    //     return response()->json();

    //  }




    public function store(Request $request)
    {

        // return response()->json($request->all());
        $account = new Account();

        $account->id = $request->post('account_id');
        $account->text = $request->post('text');
        $account->account_name_en = $request->post('account_name_en');
        if ($request->post('parent') != 0) {
            $account->parent_id = $request->post('parent');
        }

        $account->rank = $request->post('rank');
        $account->status_account = $request->post('status');
        // $account->account_type = $request->post('account_type');
        // $account->currency = $request->post('currency');

        $account->save();


        return response()->json($request->all());


        // ----------------------------------for multi--------------------------------------------------------------------


        // for ($i = 1; $i <= $request->post('count'); $i++) {

        //     $account = new Account();

        //     $account->id = $request->post('account_id')[$i];
        //     $account->text = $request->post('text')[$i];
        //     $account->account_name_en = $request->post('account_name_en')[$i];
        //     if ($request->post('account_main')[$i] == 0) {
        //         $account->parent_id = null;
        //     } else {
        //         $account->parent_id = $request->post('account_main')[$i];
        //     }

        //     $account->rank = $request->post('rank')[$i];
        //     $account->account_type = $request->post('account_type')[$i];
        //     $account->currency = $request->post('currency')[$i];

        //     $account->save();
        // }

        // return response()->json($request->all());
    }



    public function account_details_node($id)
    {


        $details = DB::table('accounts')
            ->where('accounts.id', '=', $id)
            ->select('accounts.*')
            ->get();


        $childs = Account::where('parent_id', $id)->select('accounts.*')->max('id');


        return response()->json(['childs' => $childs, 'details' => $details]);
    }


    public function account_update_node($id)
    {


        // $details = DB::table('accounts')
        // ->where('accounts.id','=', $id)
        // ->select('accounts.*')
        // ->get();


        // $childs = Account::where('parent_id', $id)->select('accounts.*')->max('id');


        // return response()->json(['childs' => $childs,'details' => $details]);




    }
   
  

    public function tree_account()
    {

        $accounts = Account::where('parent_id', null)->with('children')->get();
        $last_nodes = Account::where('parent_id', null)->select('accounts.*')->max('id');
        return response()->json(['trees' => $accounts,'last_nodes' => $last_nodes]);



        
        
    }

   

    public function chick_node($value)
    {

        $check = (in_array($value, $this->array_parent)) ? 1 : 0;
        return $check;
    }
   

    /**
     * Display the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
       
        $account = Account::find($id);
        return response()->json(['account' => $account]);
    }

    public function account_edit_node(Request $request,$id)
    {
       
        $data = Account::find($id);
        return response()->json(['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Account $account)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {

        $product = Account::find($id);

        $product->delete();
    }
}
