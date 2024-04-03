<?php

namespace App\Http\Controllers\Account;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\DailyDetail;
use Illuminate\Http\Request;
use App\Exports\AccountExport;
use App\Imports\AccountImport;
use App\Models\Bank;
use App\Models\Customer;
use App\Models\GroupType;
use App\Models\HrAccount;
use App\Models\Supplier;
use App\Models\Treasury;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{



    public function get_account_name(Request $request)
    {

        $accounts =  DailyDetail::where('daily_details.account_id', $request->id)
            ->select('daily_details.account_name')
            ->get();
        return response()->json(['accounts' => $accounts]);
    }

    public function get_group_accounts_details_details(Request $request)
    {


        $groups = DB::table('groups')
            ->where('groups.account_id', $request->id)
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->select('groups.id', 'group_types.code')
            ->get();

        foreach ($groups as $key => $value) {

            // dd($value->code);
            if ($value->code == 'customer') {

                $data = Customer::where('customers.group_id',$value->id)
                    ->select('customers.*')
                    ->get();
            }

            if ($value->code == 'supplier') {

                $data = Supplier::where('suppliers.group_id',$value->id)
                    ->select('suppliers.*')
                    ->get();
            }

            if ($value->code == 'treasury') {

                $data = Treasury::where('treasuries.group_id',$value->id)
                    ->select('treasuries.*')
                    ->get();
            }

            if ($value->code == 'bank') {

                $data = Bank::where('banks.group_id',$value->id)
                    ->select('banks.*')
                    ->get();
            }
        }


        return response()->json(['result_data' => $data]);
    }
    public function get_account(Request $request)
    {

        $accounts = DB::table('stores')->where('stores.id', $request->id)
            ->join('accounts', 'stores.account_id', '=', 'accounts.id')
            ->select('accounts.id', 'accounts.text')
            ->get();

        return response()->json(['accounts' => $accounts]);
    }


    public function auditBalance()
    {

        $sum_debit = 0;
        $sum_credit = 0;
        $auditBalances = Account::where('accounts.status_account', '=', 'false')
            ->addSelect([
                'credit' => DailyDetail::select(DB::Raw('SUM(credit)'))
                    ->whereColumn('account_id', 'accounts.id'),
                'debit' => DailyDetail::select(DB::Raw('SUM(debit)'))
                    ->whereColumn('account_id', 'accounts.id'),
                'balance' => DailyDetail::select(DB::raw('SUM(credit)-SUM(debit)'))
                    ->whereColumn('account_id', 'accounts.id')
            ])
            ->get();

        foreach ($auditBalances as $value) {

            $sum_debit += $value->debit;
            $sum_credit += $value->credit;
        }

        return response()->json([
            'auditBalances' => $auditBalances,
            'sum_debit' => $sum_debit,
            'sum_credit' => $sum_credit
        ]);
    }

    public function AccountStatement(Request $request)
    {


        $daily_details =  DailyDetail::where('daily_details.account_id', $request->id)
            ->join('dailies', 'dailies.id', '=', 'daily_details.daily_id')
            ->select('dailies.daily_date', 'daily_details.*')
            ->get();
        return response()->json(['daily_details' => $daily_details]);
    }



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

        Cache::forget('tree_accounts');
        Cache::forget('tree_accounts_node');

        return response()->json($request->all());
    }


    // public function get_account_account_setting()
    // {



    //     $accounts = HrAccount::with(
    //         [
    //             'account' => function ($query) {
    //                 $query->select('*', 'text as first_name');
    //             },
    //             'account_second' => function ($query) {
    //                 $query->select('*', 'text as second_name');
    //             }
    //         ]
    //     )->select('hr_accounts.*', 'hr_accounts.name as account_name')
    //         ->get();

    //     // dd($accounts);
    //     $count_account = HrAccount::all()->count();

    //     return response()->json(['accounts' => $accounts, 'count_account' => $count_account]);
    // }


    public function get_group_bank_treasury()
    {


        $groups =  DB::table('groups')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->whereIn('group_types.code', ['bank', 'treasury'])
            // ->where('group_types.code','treasury')
            ->select(
                'groups.*',
                'group_types.name as type_name'
            )
            ->get();

        $group_types =  DB::table('group_types')->whereIn('group_types.code', ['bank', 'treasury'])->select(
            'group_types.name as type_name'
        )
            ->get();
        return response()->json(['groups' => $groups, 'group_types' => $group_types]);
    }
    public function get_bank_treasury()
    {


        $treasury_groups =  DB::table('groups')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->whereIn('group_types.code', ['treasury'])
            // ->where('group_types.code','treasury')
            ->select(
                'groups.*',
                'group_types.name as type_name'
            )
            ->get();

        $bank_groups =  DB::table('groups')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->whereIn('group_types.code', ['bank'])
            // ->where('group_types.code','treasury')
            ->select(
                'groups.*',
                'group_types.name as type_name'
            )
            ->get();

        return response()->json([
            'treasury_groups' => $treasury_groups,
            'bank_groups' => $bank_groups,
        ]);
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

        $accounts = Cache::rememberForever('tree_accounts', function () {

            return Account::where('parent_id', null)->with('children')->get();
        });
        $last_nodes = Cache::rememberForever('tree_accounts_node', function () {

            return Account::where('parent_id', null)->select('accounts.*')->max('id');
        });

        return response()->json(['trees' => $accounts, 'last_nodes' => $last_nodes]);
    }


    public function import(Request $request)
    {

        Excel::import(new AccountImport, storage_path('account.xlsx'));

        return response()->json([
            'status' =>
            'The file has been excel/csv imported to database in laravel 9'
        ]);
    }


    public function export()
    {

        return Excel::download(new AccountExport, 'account.xlsx');
    }


    public function chick_node($value)
    {

        // $check = (in_array($value, $this->array_parent)) ? 1 : 0;
        // return $check;
    }


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

    public function account_edit_node(Request $request, $id)
    {

        $data = Account::find($id);
        return response()->json(['data' => $data]);
    }





    public function destroy($id)
    {

        $product = Account::find($id);

        $product->delete();
    }
}
