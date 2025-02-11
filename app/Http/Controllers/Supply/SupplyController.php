<?php

namespace App\Http\Controllers\Supply;

use Illuminate\Support\Facades\Cache;
use App\Models\StoreProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Traits\Invoice\InvoiceTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\status;
use App\Models\Temporale;
use App\Models\Supply;
use App\Repository\Qty\QtyStockRepository;
use App\Services\StockService;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SupplyController extends Controller
{
    use InvoiceTrait,
        GeneralTrait;
    public $qty;

    public function __construct(QtyStockRepository $qty)
    {

        $this->qty = $qty;
    }
    public function details(Request $request, $id)
    {

        $this->qty->compare_array = ['qty'];
        $this->get_details($request, $id);
        $this->qty->handle_qty();
        return response()->json([
            'details' => $this->qty->details,

        ]);
    }


    public function index()
    {


        $products = DB::table('products')
            ->select('products.*',)
            ->get();


        return response()->json([
            'products' => $products,
            'suppliers' => $this->suppliers(),
            'statuses' => Status::all(),
            'stores' => $this->get_store()

        ]);
    }



    public function get_store()
    {

        return DB::table('stores')
            ->select(
                'stores.account_id as store_account_id',
                'stores.text as store_name',
                'stores.id as store_id'

            )
            ->get();
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
            ->join('accounts', 'accounts.id', '=', 'treasuries.account_id')
            ->select(
                'treasuries.id',
                'treasuries.name',
                'treasuries.account_id'

            )
            ->get();

        return $treasuries;
    }

    public function payment(
        StockService $stock
    ) {


        // dd($stock->core->data);

        // $result  = $this->daily->check_account();

        // if ($result == 0) {

        //     return response([
        //         'message' => $this->daily->message,
        //         'status' => 'failed'
        //     ], 400);
        // }

        // dd($this->core->data);


        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            // $stock->core->data['count'];
            $stock->handle();
            Cache::forget('stock');
            // ------------------------------------------------------------------------------------------------------
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB


            return response([
                'message' => "supply created successfully",
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
    public function supply_daily(Request $request)
    {



        $supplies = DB::table('supplies')
            ->where('supplies.id', $request->id)
            ->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id')
            ->join('dailies', 'dailies.id', '=', 'supplies.daily_id')
            ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
            ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
            ->select(
                // 'supplies.*',
                'supplies.id as supply_id',
                'suppliers.name',
                'dailies.*',
                'daily_details.*',
                'accounts.text',
                'accounts.id as account_id',


            )
            ->get();

        // dd($supplies);
        return response()->json(['daily_details' => $supplies]);
    }

    public function show()
    {


        $supplies = Payment::with(['Paymentable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                Supply::class => function ($query) {

                    $query->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id');
                    $query->join('dailies', 'dailies.id', '=', 'supplies.daily_id');
                    $query->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id');
                    $query->join('accounts', 'accounts.id', '=', 'daily_details.account_id');
                    $query->where('daily_details.credit', '!=', 0);


                    $query->select(
                        'supplies.*',
                        'supplies.id as supply_id',
                        'accounts.text',
                        'accounts.id as account_id',
                    );
                },
            ]);
        }])
            ->where('paymentable_type', 'App\\Models\\Supply')
            ->paginate(5);


        return response()->json(['supplies' => $supplies]);
    }

    public function supply_list()
    {


        $supplies = Payment::with(['Paymentable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                Supply::class => function ($query) {

                    $query->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id');


                    $query->select(
                        'supplies.*',
                        'supplies.id as supply_id',

                    );
                },
            ]);
        }])
            ->where('paymentable_type', 'App\\Models\\Supply')
            ->paginate(5);


        return response()->json(['supplies' => $supplies]);
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

    public function invoice_supply(Request $request, $id)
    {

        $this->qty->compare_array = ['qty'];
        $this->get_details($request, $id);
        $this->qty->handle_qty();
        return response()->json([
            'supply_details' => $this->qty->details,
            'supplies' => $this->get_supply($id),
            'users' => Auth::user()
        ]);
    }


    public function get_supply($id)
    {

        return Supply::where('supplies.id', $id)
            ->join('suppliers', 'suppliers.id', '=', 'supplies.supplier_id')
            ->select('supplies.*', 'supplies.id as cash_id', 'suppliers.*')
            ->get();
    }
    public function destroy(Request $request)
    {
        if ($request->id) {
            Temporale::where('type_process', 'supply')->where('temporales.product_id', $request->id)->delete();
        } else {
            Temporale::where('type_process', 'supply')->delete();
        }


        return response()->json('successfully deleted');
    }
}
