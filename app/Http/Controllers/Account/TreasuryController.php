<?php

namespace App\Http\Controllers\Account;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Treasury;
use App\Models\Account;
use DB;

class TreasuryController extends Controller
{


    public function index()
    {

        $treasuries = Treasury::all();
        return response()->json(['treasuries' => $treasuries]);
    }

    public function store(Request $request)
    {



        // dd($request->all());

        foreach ($request->post('count') as $value) {

            // -------------------------------------------------------------------------
            $parent =  DB::table('accounts')
                ->where('accounts.id', $request['account'])
                ->select(
                    'accounts.*',

                )
                ->first();

            // ---------------------------------------------------------------------------

            $childs = Account::where('parent_id', $parent->id)->select('accounts.*')->max('id');
            $id = ($childs == null) ? $request['account'] * 10 + 1 : $childs + 1;

            // dd($id);
            // -------------------------------------------------------------------------

            $account = new Account();
            $account->id = $id;
            $account->text = $request['name'][$value];
            $account->parent_id = $parent->id;
            $account->rank = $parent->rank + 1;
            $account->status_account = false;
            $account->save();
            // -------------------------------------------------------------------------

            $treasury = new Treasury();
            $treasury->account_id =  $id;
            $treasury->name =  $request['name'][$value];
            $treasury->save();
        }

        return response()->json(['message' => 'success']);
    }


    public function show()
    {
        $treasuries = DB::table('treasuries')
            ->join('accounts', 'accounts.id', '=', 'treasuries.account_id')
            ->select('treasuries.*', 'accounts.text', 'accounts.id as account_id')
            ->paginate(10);

        return response()->json(['treasuries' => $treasuries]);
    }
}
