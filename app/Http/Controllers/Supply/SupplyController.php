<?php

namespace App\Http\Controllers\Supply;
use App\Repository\StoreInventury\StoreSupplyRepository;
use App\Repository\StockInventury\StockSupplyRepository;
use Illuminate\Support\Facades\Cache;
use App\Repository\Stock\SupplyRepository;
use App\Services\UnitService;
use App\Models\StoreProduct;
use App\Services\SupplyPaymentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Traits\Invoice\InvoiceTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\status;
use App\Models\Temporale;
use App\Models\Supply;
use App\Services\CoreService;
use App\Services\DailyService;


class SupplyController extends Controller
{
    use InvoiceTrait,
        GeneralTrait;


    public function __construct(

        protected CoreService $core,
        protected SupplyPaymentService $payment,
        protected UnitService $unit,
        Request $request,

    ) {


        $this->core->setData($request->all());
        $this->core->setDiscount($request['discount'] * $request['grand_total'] / 100);
    }

    public function details(Request $request, $id)
    {

        $details = $this->get_details($request, $id);

        $this->units($details);

        return response()->json([
            'details' => $details,

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
            'treasuries' => $this->treasuries()
        ]);
    }



    public function suppliers()
    {

        $suppliers =  DB::table('suppliers')
            ->join('accounts', 'suppliers.account_id', '=', 'accounts.id')
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
        DailyService $daily,
        StoreSupplyRepository $store,
        StockSupplyRepository $stock,
        SupplyRepository $warehouse,
    ) {


        // dd($this->core->data);

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

            $warehouse->add(); // this insert data into purchase table

            foreach ($this->core->data['count'] as $value) {

                $this->core->setValue($value);
      
                $this->unit->unit_and_qty(); // this make decode for unit and convert qty into miqro
              
                $store->store(); // this handle data in store_product table


                $warehouse->init_details(); // this make initial for details table

                $stock->stock(); // this handle data in stock table

            }

            $this->payment->pay();
            $daily->daily()->debit()->credit();
            $warehouse->refresh(); //this update purchase table by daily_id
            Cache::forget('stock');
            dd(Supply::all());

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
    public function show(Request $request)
    {

        $purchases = DB::table('purchases')
            ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
            ->join('payment_purchases', 'payment_purchases.purchase_id', '=', 'purchases.id')
            ->select(
                'purchases.*',
                'purchases.id as purchases_id',
                'suppliers.*',
                'payment_purchases.*',
                'payment_purchases.payment_status'
            )
            ->paginate(10);

        return response()->json(['purchases' => $purchases]);
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

        $purchases = Supply::where('purchases.id', $id)
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
