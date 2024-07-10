<?php

namespace App\Http\Controllers\Warehouse;

use App\Repository\StoreInventury\StoreTransferRepository;
use App\Repository\StockInventury\StockTransferRepository;
use App\Repository\CheckData\CheckTransferRepository;
use App\Traits\Transfer\StoreProductTrait;
use App\Repository\Stock\TransferRepository;
use App\Traits\Details\DetailsTrait;
use App\Traits\GeneralTrait;
use App\Models\Product;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\TransferDetail;
use App\Services\CoreService;

use App\Http\Controllers\Controller;
use App\Repository\Qty\QtyStockRepository;
use App\RepositoryInterface\UnitRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{

    use StoreProductTrait,
        DetailsTrait,
        GeneralTrait;

    public function __construct(
        Request $request,
        public QtyStockRepository $qty,
        public CoreService $core,

    ) {

        // dd($request->all());
        $this->qty = $qty;
        $this->core->setData($request->all());
    }




    public function index()
    {
        $transfers = Transfer::all();

        return response()->json($transfers);
    }


    public function create($date)
    {
        $transfer = new Transfer();
        $transfer->date =  $date;

        $transfer->save();
        return $transfer->id;
    }

    public function get_product(Request $request, QtyStockRepository $qty)
    {




        $qty->compare_array = ['quantity'];
        $qty->details = ($request->post('type_search') == 'store') ?
            $this->get_store_product_with_store($request) :
            $this->get_store_product_with_product($request);
        $qty->handle_qty();


        // $this->units($products);
        return response()->json(['products' => $qty->details]);
    }


    public function get_transfer_for_recive(Request $request)
    {

        $transfer_details = TransferDetail::where('transfer_details.transfer_id', $request->id)
            ->jointransfer()
            ->select(
                'products.*',
                'transfer_details.*',
                'units.name as unit',
                'products.text as product',
                'statuses.name as status',
                'stores.text as store',
                'store_products.desc',
            )
            ->get();
        $this->units($transfer_details);


        return response()->json(['transfer_details' => $transfer_details]);
    }
    public function get_store_product_with_store($request)
    {


        return StoreProduct::where('store_products.quantity', '!=', 0)
            ->where('product_units.unit_type', '==', 0)
            ->where('store_products.store_id', $request['id'])
            ->join('products', 'products.id', '=', 'store_products.product_id')
            ->join('stores', 'stores.id', '=', 'store_products.store_id')
            ->join('statuses', 'statuses.id', '=', 'store_products.status_id')
            ->join('product_units', 'product_units.product_id', '=', 'products.id')
            ->join('units', 'units.id', '=', 'product_units.unit_id')
            ->select(
                'store_products.quantity',
                'store_products.*',
                'store_products.id as store_product_id',
                'units.name as unit',
                'products.id',
                'products.text as product',
                'product_units.rate',
                'statuses.name as status',
                'stores.text as store'
            )
            ->get();
    }

    public function get_store_product_with_product($request)
    {


        return  StoreProduct::where('store_products.quantity', '!=', 0)
            ->where('product_units.unit_type', '==', 0)
            ->where('store_products.product_id', $request['id'])
            ->join('products', 'products.id', '=', 'store_products.product_id')
            ->join('stores', 'stores.id', '=', 'store_products.store_id')
            ->join('statuses', 'statuses.id', '=', 'store_products.status_id')
            ->join('product_units', 'product_units.product_id', '=', 'products.id')
            ->join('units', 'units.id', '=', 'product_units.unit_id')
            ->select(
                'store_products.quantity',
                'store_products.*',
                'units.name as unit',
                'products.id',
                'products.text as product',
                'product_units.rate',
                'statuses.name as status',
                'stores.text as store'
            )
            ->get();
    }




    public function data_for_transfer()
    {

        $products = Product::all();
        return response()->json(['products' => $products]);
    }





    public function store(

        StoreTransferRepository $store,
        StockTransferRepository $stock,
        TransferRepository $warehouse,
        UnitRepositoryInterface $unit,
        CheckTransferRepository $check,
    ) {



        // dd($this->core->data);
        try {

            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            $warehouse->add(); // this handle data in transfer table

            // dd($this->core->data);
            foreach ($this->core->data['count'] as $value) {

                // -------------------------------------------------------------------------------------

                // $result = $check->check_return($this->core->data['old'][$value]);

                // if ($result['status'] == 0) {

                //     return response(['message' => $result['text'], 'status' => $result['status']]);
                // }
                // -------------------------------------------------------------------------------------
                // dd(90);
                $this->core->setValue($value);  //this set index of data

                $unit->handle_unit(); // this make decode for unit and convert qty into miqro
                $unit->convert_unit(); // this make decode for unit and convert qty into miqro
                // dd(12);
                $store->store(); // this handle data in store table

                $warehouse->init_details(); // this make initial for details table

                $stock->stock(); // this handle data in stock table

                // dd(176);

            }



            // dd('sdsdsd');

            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB
            return response([
                'message' => "transfer created successfully",
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




    public function show(Request $request)
    {



        $transfer_details = DB::table('transfer_details')
            ->join('products', 'transfer_details.product_id', '=', 'products.id')
            ->join('statuses', 'transfer_details.status_id', '=', 'statuses.id')
            ->join('stores', 'transfer_details.store_id', '=', 'stores.id')
            ->join('units', 'transfer_details.unit_id', '=', 'units.id')
            ->select(
                'products.*',
                'units.name as unit',
                'transfer_details.*',
                'statuses.*',
                'statuses.name as status',
                'stores.*'
            )
            ->get();

        foreach ($transfer_details as $value) {

            $value->qty_transfer = 0;
            $value->unit_selected = [];
        }
        $this->units($transfer_details);
        return response()->json(['transfer_details' => $transfer_details]);
    }

    public function details_transfer($id)
    {

        $this->qty->compare_array = ['qty'];

        $this->get_details($id);

        $this->qty->handle_qty();


        return response()->json(['transfer_details' => $this->qty->details]);
    }

    public function  get_details($id)
    {




        $this->qty->details = TransferDetail::where('transfer_details.transfer_id', $id)
            ->jointransfer()
            ->select(
                'products.*',
                'products.id as product_id',
                'transfer_details.*',
                'products.text as product',
                'statuses.name as status',
                'store_products.desc',
            )
            ->get();

        foreach ($this->qty->details as $value) {

            $value->qty_return_now = 0;
            $value->unit_selected = [];
        }
    }
}
