<?php

namespace App\Http\Controllers\Account;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Services\TreeService;
use App\Models\Account;
use App\Models\DailyDetail;
use Illuminate\Http\Request;
use App\Exports\AccountExport;
use App\Imports\AccountImport;
use App\Models\Bank;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Treasury;

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
            // dd(123);

        foreach ($groups as $key => $value) {

            // dd($value->code);
            if ($value->code == 'customer') {

                $data = Customer::where('customers.group_id', $value->id)
                    ->select('customers.*')
                    ->get();
                $type = $value->code;
            }

            if ($value->code == 'supplier') {

                $data = Supplier::where('suppliers.group_id', $value->id)
                    ->select('suppliers.*')
                    ->get();
                $type = $value->code;
            }

            if ($value->code == 'treasury') {

                $data = Treasury::where('treasuries.group_id', $value->id)
                    ->select('treasuries.*')
                    ->get();
                $type = $value->code;
            }

            if ($value->code == 'bank') {

                $data = Bank::where('banks.group_id', $value->id)
                    ->select('banks.*')
                    ->get();
                $type = $value->code;
            }
        }


        return response()->json([
            'result_data' => $data,
            'group_type' => $type
        ]);
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


    public function get_bank_accounts()
    {

        $bank_groups =  DB::table('groups')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->where('group_types.code', 'bank')
            ->select(
                'groups.*',
            )
            ->get();


        $bank_accounts =  DB::table('groups')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->join('accounts', 'accounts.id', '=', 'groups.account_id')
            ->where('group_types.code', 'bank')
            ->select(
                'groups.*',
                'accounts.*',
            )
            ->get();

        return response()->json([
            'bank_groups' => $bank_groups,
            'bank_accounts' => $bank_accounts,

        ]);
    }

    public function get_treasury_accounts()
    {


        $treasury_groups =  DB::table('groups')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->where('group_types.code', 'treasury')
            ->select(
                'groups.*',
            )
            ->get();

        $treasury_accounts =  DB::table('groups')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->join('accounts', 'accounts.id', '=', 'groups.account_id')
            ->where('group_types.code', 'treasury')
            ->select(
                'groups.*',
                'accounts.*',
            )
            ->get();


        return response()->json([
            'treasury_groups' => $treasury_groups,
            'treasury_accounts' => $treasury_accounts,

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


    public function tree_account(Request $request, TreeService $tree)
    {



        // dd($request->all());
        if ($request['value']) {

            $tree->check_tree($request);
            $tree->tree_part();
        } else {


            $tree->tree();
        }

        return response()->json([
            'trees' => $tree->accounts,
            'last_nodes' => $tree->last_nodes
        ]);
    }


    // public function tree_account(Request $request)
    // {


    //     if ($request['value']) {

    //         if ($request['value'] == 1) {

    //             $account = $this->get_type_tree(2);
    //         }
    //         if ($request['value'] == 2) {

    //             $account = $this->get_type_tree(3);
    //         }

    //         if ($request['value'] == 3) {

    //             $account = $this->get_type_tree(1);
    //         }



    //         $accounts =  Account::where('id', $account[0]->account_id)->with('children')->get();
    //         $last_nodes =  Account::where('id', $account[0]->account_id)
    //             ->select('accounts.*')
    //             ->max('id');
    //     } else {

    //         $accounts = Cache::rememberForever('tree_accounts', function () {

    //             return Account::where('parent_id', null)->with('children')->get();
    //         });
    //         $last_nodes = Cache::rememberForever('tree_accounts_node', function () {

    //             return Account::where('parent_id', null)->select('accounts.*')->max('id');
    //         });
    //     }



    //     return response()->json([
    //         'trees' => $accounts,
    //         'last_nodes' => $last_nodes
    //     ]);
    // }

    // public function get_type_tree($group)
    // {



    //     return collect(DB::table('groups')
    //         ->where('group_type_id', '=', $group)
    //         ->where('status', '=', 0)
    //         ->select('account_id')
    //         ->get())->toArray();
    // }
    // public function get_part_tree_account(Request $request)
    // {

    //     $accounts =  Account::where('id', 221)->with('children')->get();

    //     $last_nodes =  Account::where('id', 221)->select('accounts.*')->max('id');


    //     return response()->json(['trees' => $accounts, 'last_nodes' => $last_nodes]);
    // }



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
