<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TreeService
{

    public $accounts;
    public $account;
    public $last_nodes;


    public function check_tree(Request $request)
    {

        if ($request['value'] == 1) {

            $this->account = $this->get_type_tree('treasury');
        }

        if ($request['value'] == 2) {


            if ($request['type'] == 'Purchase' || $request['type'] == 'Supply' || $request['type'] == 'PurchaseReturn' || $request['type'] == 'SupplyReturn') {


                // dd('sdsdsd',$this->account);
                $this->account = $this->get_type_tree('supplier');
         
            }

            if ($request['type'] == 'Sale' || $request['type'] == 'Cash' || $request['type'] == 'SaleReturn' || $request['type'] == 'CashReturn') {

                $this->account = $this->get_type_tree('customer');
            }
        }

        if ($request['value'] == 3) {

            $this->account = $this->get_type_tree('bank');
        }
    }


    public function get_type_tree($group)
    {



        return collect(DB::table('groups')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->where('group_types.code', '=',$group)
            ->where('groups.status', '=', 0)
            ->select('groups.account_id')
            ->get())->toArray();
    }

    public function tree()
    {




        $this->accounts = Cache::rememberForever('tree_accounts', function () {

            return Account::where('parent_id', null)->with('children')->get();
        });
        $this->last_nodes = Cache::rememberForever('tree_accounts_node', function () {

            return Account::where('parent_id', null)->select('accounts.*')->max('id');
        });
    }


    public function tree_part()
    {


        // dd($this->account[0],$this->last_nodes);

        $this->accounts =  Account::where('id', $this->account[0]->account_id)->with('children')->get();
        $this->last_nodes =  Account::where('id', $this->account[0]->account_id)
            ->select('accounts.*')
            ->max('id');

            // dd($this->accounts,$this->last_nodes);
    }
}
