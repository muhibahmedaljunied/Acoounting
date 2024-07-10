<?php

namespace App\Http\Controllers\Account;


use App\Models\Bank;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankController extends Controller
{


    public function index()
    {



        $banks = Bank::all();
        return response()->json(['banks' => $banks]);
    }

    public function store(Request $request)
    {


        // $validator = Validator::make($request->all(), [
        //     'Bank_type' => 'required',
        //     'qty' => 'required',

        // ]);

        // if($validator->fails()){
        //     return response()->json(['error' => $validator->errors()], 401);
        // }

        // dd($request->all());
        foreach ($request->post('count') as $value) {

            // -------------------------------------------------------------------------
            // $parent =  DB::table('accounts')
            //     ->where('accounts.id', $request['account'])
            //     ->select(
            //         'accounts.*',
            //     )
            //     ->first();

            // ---------------------------------------------------------------------------

            // $childs = Account::where('parent_id', $parent->id)->select('accounts.*')->max('id');
            // $id = ($childs == null) ? $request['account'] * 10 + 1 : $childs + 1;

            // dd($id);
            // -------------------------------------------------------------------------

            // $account = new Account();
            // $account->id = $id;
            // $account->text = $request['name'][$value];
            // $account->parent_id = $parent->id;
            // $account->rank = $parent->rank + 1;
            // $account->status_account = false;
            // $account->save();
            // -------------------------------------------------------------------------

            $bank = new Bank();
            // $bank->account_id =  $id;
            $bank->name =  $request['name'][$value];
            $bank->group_id =  $request['group'][$value];

            $bank->save();
        }

        return response()->json(['message' => 'success']);
    }


    public function show()
    {
        // $banks = DB::table('banks')
        //     ->join('accounts', 'accounts.id', '=', 'banks.account_id')
        //     ->select('banks.*', 'accounts.text', 'accounts.id as account_id')
        //     ->paginate(10);

        $banks =  DB::table('banks')
            ->join('groups', 'groups.id', '=', 'banks.group_id')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->where('group_types.code', 'bank')
            ->select(
                'banks.*',
                'groups.name as group_name'
            )
            ->paginate(10);

        $groups =  DB::table('groups')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->where('group_types.code', 'bank')
            ->select(
                'groups.*'
            )
            ->get();



            // dd($groups);
        return response()->json(['banks' => $banks, 'groups' => $groups]);
    }
}
