<?php

namespace App\Http\Controllers\Purchase;

use App\Repository\StoreInventury\StorePurchaseRepository;
use App\Repository\StockInventury\StockPurchaseRepository;
use App\Repository\Stock\PurchaseRepository;
use App\Services\UnitService;
use App\Models\PaymentPurchase;
use App\Models\StoreProduct;
use App\Services\PurchaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Daily;
use App\Models\DailyDetail;
use App\Traits\Invoice\InvoiceTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\status;
use App\Models\Temporale;
use App\Models\Purchase;
use App\Services\CoreService;
use App\Services\DailyService;
use App\Models\PayableNote;


class PurchaseController extends Controller
{
    use InvoiceTrait,
        GeneralTrait;


    public function __construct(

        protected CoreService $core,
        protected PurchaseService $purchase,
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
            )
            ->get();

        return $treasuries;
    }

    public function payment(
        StorePurchaseRepository $store,
        StockPurchaseRepository $stock,
        PurchaseRepository $warehouse,
    ) {



        // $result  = $this->daily->check_account();

        // if ($result == 0) {

        //     return response([
        //         'message' => $this->daily->message,
        //         'status' => 'failed'
        //     ], 400);
        // }




        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            $warehouse->add(); // this insert data into purchase table

            foreach ($this->core->data['count'] as $value) {

                $this->core->setValue($value + 1);

                $this->unit->unit_and_qty(); // this make decode for unit and convert qty into miqro

                $store->store(); // this handle data in store_product table

                $warehouse->init_details(); // this make initial for details table

                $stock->stock(); // this handle data in stock table
            }

            $this->purchase->pay();

            // dd('sdsdsd');
            // $this->daily->daily();


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








    public function payment_bond(Request $request)
    {

        $data = DB::table('purchases')
            ->where('purchases.id', $request->id)
            ->join('payment_purchases', 'payment_purchases.purchase_id', '=', 'purchases.id')
            ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
            ->join('accounts', 'accounts.id', '=', 'suppliers.account_id')

            ->select(
                'purchases.*',
                'suppliers.id',
                'suppliers.name',
                'payment_purchases.*',
                'accounts.id as account_id',
                'accounts.text'
            )
            ->get();
        return response()->json(['list_data' => $data]);
    }

    public function store_PaymentBond(
        Request $request,
        DailyService $daily,
    )
    {



        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction




            $daily->daily('date','total')
            ->depit('account_id'])
            ->credit(['account_id', 'account_id', 'account_id'])
            ->set();

            // -------------------------------------------------------------

            // $data = new Daily();
            // $data->date = $request->post('date');
            // $data->total = $request->post('paid');
            // $data->save();

            // -------------------------------------------------------------

            // $data = new DailyDetail();
            // $data->daily_id = $request->post('purchase_id');
            // $data->account_id = $request->post('purchase_id');
            // $data->description = $request->post('paid');
            // $data->debit = $request->post('debit');
            // $data->credit = $request->post('credit');
            // $data->save();

            // -------------------------------------------------------------

            // $data = new PayableNote();
            // $data->purchase_id = $request->post('purchase_id');
            // $data->paid = $request->post('paid');
            // $data->date = $request->post('date');
            // $data->save();


            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

            return response([
                'message' => "daily created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"


            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }


        return response()->json(['list_data' => $data]);
    }

    public function payment_bond_store(Request $request)
    {


        $payment = PaymentPurchase::find($request->id);
        if ($request->post('total_remaining') == 0) {
            $array_data = ['payment_status' => 'paiding', 'paid' => 1212, 'remaining' => 1212];
        }
        if ($request->post('total_remaining') > 0) {
            $array_data = ['payment_status', 'Partialy'];
        }

        $payment->update($array_data);
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
                'payment_purchases.*'
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
