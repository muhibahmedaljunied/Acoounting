<?php

namespace App\Http\Controllers\Sale;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\Account;
use App\Http\Controllers\Controller;

use DB;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
    {

        $customers = DB::table('customers')
            // ->join('customer_accounts', 'customer_accounts.customer_id', '=', 'customers.id')
            ->join('accounts', 'customers.account_id', '=', 'accounts.id')

            ->select(
                'customers.*',
                // 'customer_accounts.account_id',
                'accounts.text'
            )
            ->paginate(10);



        return response()->json($customers);
    }

    public function search(Request $request)
    {
        $customers = Customer::where('customers.name', 'LIKE', '%' . $request->post('word_search') . '%')
            ->select('customers.*')
            ->paginate(10);
        return response()->json($customers);
    }


    public function create()
    {
    }

    public function show(Request $request)
    {
        // return response()->json(['sales' => $request->all()]);

        $sales =  Sale::where('customer_id', $request->id)->with([
            'payment_sales' => function ($query) {
                $query->select('*');
            },
            'sale_returns' => function ($query) {
                $query->select('*');
            }
            // ,
            // 'receivable_notes' => function ($query) {
            //     $query->select('*');
            // }

        ])->paginate(10);





        return response()->json(['sales' => $sales]);
    }



    public function store(Request $request)
    {




        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction



            // -------------------------------------------------------------------------
            $parent =  DB::table('accounts')
                ->where('accounts.id', $request->post('account'))
                ->select(
                    'accounts.id',
                    'accounts.text',
                    'accounts.rank',
                )
                ->first();


            // -------------------------------------------------------------------------

            $childs = Account::where('parent_id', $parent->id)->select('accounts.*')->max('id');
            $id = ($childs == null) ? $request->post('account') * 10 + 1 : $childs + 1;

            // ----------------------------------------------------------------------------------
            $account = new Account();
            $account->id = $id;
            $account->text = 'العميل' . ' ' . $request->post('name');
            $account->parent_id = $parent->id;
            $account->rank = $parent->rank + 1;
            $account->status_account = false;
            $account->save();

            // -------------------------------------------------------------------------
            $customer = new Customer();
            $customer->name = $request->post('name');
            $customer->phone = $request->post('phone');
            $customer->email = $request->post('email');
            $customer->address = $request->post('address');
            $customer->account_id = $id;
            $customer->status = $request->post('status');
            $customer->save();



            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"


            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }

        return back();
    }




    public function edit($id)
    {
        $customer = Customer::find($id);
        return response()->json(['customer' => $customer]);
    }

    public function update(Request $request)
    {
        $customer = Customer::find($request->id);
        $customer->update($request->post());
        return response()->json($customer);
    }

    public function destroy($id)
    {
        $customer = Customer::find($id);

        $customer->delete();

        return response()->json('successfully deleted');
    }
}
