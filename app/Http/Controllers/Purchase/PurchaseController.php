<?php

namespace App\Http\Controllers\Purchase;

use App\Services\StockService;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Models\Payment;
use Illuminate\Support\Facades\Cache;
use App\Models\StoreProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\HrAccount;
use App\Traits\Invoice\InvoiceTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\status;
use App\Models\Temporale;
use App\Models\Purchase;



class PurchaseController extends Controller
{
    use InvoiceTrait,
        GeneralTrait;


    public $units;
    public $value;
    public $key;

    public $quantity = 0;
    public $r = array(

        array()
    );

    public function details(Request $request, $id)
    {

        $details = $this->get_details($request, $id);

        foreach ($details as $key => $value) {

            $this->value = $value;
            $this->units();
            $this->convert_qty($value->qty);
        }

        return response()->json([
            'details' => $details,

        ]);
    }

    public function convert_qty($qty)
    {


        $this->quantity = $qty;

        foreach ($this->units as $key2 => $value2) {



            if ($this->quantity / $value2->rate >= 1) {


                $this->r["$this->key"]["$key2"] = array(

                    // "$key2" => array(
                    [intval($this->quantity / $value2->rate), $value2->name]
                    // )
                );
            }

            if ($this->quantity % $value2->rate >= 1) {

                $this->quantity = $this->quantity % $value2->rate;
            } else {

                break;
            }

            // $this->divid_one($value2, $key);




        }

        $this->value->qty_after_convert = $this->r;
        // dd($this->r);
        $this->r = array(
            array()
        );
    }
    public function index()
    {


        $products = DB::table('products')
            ->select('products.*',)
            ->get();

        $stores = DB::table('stores')
            ->select(
                'stores.account_id as store_account_id',
                'stores.text as store_name',
                'stores.id as store_id'

            )
            ->get();


        return response()->json([
            'products' => $products,
            'suppliers' => $this->suppliers(),
            'statuses' => Status::all(),
            // 'treasuries' => $this->treasuries(),
            'stores' => $stores

        ]);
    }



    public function suppliers()
    {

        $suppliers =  DB::table('suppliers')
            // ->join('accounts', 'suppliers.account_id', '=', 'accounts.id')
            ->select(
                'suppliers.*',

            )
            ->get();

        return $suppliers;
    }

    public function treasuries()
    {

        $treasuries = DB::table('treasuries')
            // ->join('accounts', 'accounts.id', '=', 'treasuries.account_id')
            ->select(
                'treasuries.id',
                'treasuries.name',
                // 'treasuries.account_id'

            )
            ->get();

        return $treasuries;
    }

    public function payment(

        StockService $stock,
    ) {



        // dd($stock->core->data);
        // $result  = $this->daily->check_account();

        // if ($result == 0) {

        //     return response([
        //         'message' => $this->daily->message,
        //         'status' => 'failed'
        //     ], 400);
        // }




        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            $stock->handle();

            // dd(2);
            Cache::forget('stock');

            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB


            return response([
                'message' => "purchase created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"


            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }
    }
    public function purchase_daily(Request $request)
    {



        $purchases = DB::table('purchases')
            ->where('purchases.id', $request->id)
            ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->join('dailies', 'dailies.id', '=', 'purchases.daily_id')
            ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
            ->select(
                // 'purchases.*',
                'purchases.id as purchase_id',
                'suppliers.name',
                'dailies.*',
                'daily_details.*',
                'accounts.text',
                'accounts.id as account_id',


            )
            ->get();

        // dd($purchases);
        return response()->json(['daily_details' => $purchases]);
    }


    public function show()
    {


        $purchases = Payment::with(['Paymentable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                Purchase::class => function ($query) {
                    $query->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id');
                    $query->select('purchases.*', 'purchases.id as purchase_id');
                },
            ]);
        }])
            ->where('paymentable_type', 'App\\Models\\Purchase')
            ->paginate(5);


        return response()->json(['purchases' => $purchases]);
    }

    public function get_purchase_account_setting()
    {



        $accounts = HrAccount::with(
            [
                'account' => function ($query) {
                    $query->select('*', 'text as first_name');
                },
                'account_second' => function ($query) {
                    $query->select('*', 'text as second_name');
                }
            ]
        )->select('hr_accounts.*', 'hr_accounts.name as account_name')
            ->get();

        // dd($accounts);
        $count_account = HrAccount::all()->count();

        return response()->json(['accounts' => $accounts, 'count_account' => $count_account]);
    }
    public function search(Request $request)
    {

        $products = StoreProduct::where('products.name', 'LIKE', '%' . $request->post('word_search') . '%')
            ->join('stores', 'store_products.store_id', '=', 'stores.id')
            ->join('products', 'store_products.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('group_categories', 'group_categories.id', '=', 'categories.group_id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'stores.text as store',
                'group_categories.name as group_name'
            )
            ->paginate(10);

        return response()->json(['products' => $products]);
    }

    public function invoice_purchase($id, $table = 'purchase_details')
    {

        $purchases = Purchase::where('purchases.id', $id)
            ->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->select(
                'purchases.*',
                'purchases.id as purchase_id',
                'purchases.*'
            )
            ->get();

        $details = $this->invoice($id, $table);

        $users = Auth::user();

        return response()->json([$table => $details, 'purchases' => $purchases, 'users' => $users]);
    }
    public function destroy(Request $request)
    {
        if ($request->id) {
            Temporale::where('type_process', 'purchase')->where('temporales.product_id', $request->id)->delete();
        } else {
            Temporale::where('type_process', 'purchase')->delete();
        }


        return response()->json('successfully deleted');
    }
}
