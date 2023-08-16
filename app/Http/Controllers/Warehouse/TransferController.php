<?php

namespace App\Http\Controllers\Warehouse;

use App\RepositoryInterface\StockRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Traits\StoreProduct\StoreProductTrait;
use App\Traits\Details\DetailsTrait;
use App\Traits\Temporale\TemporaleTrait;
use App\Services\InventureService;
use App\Traits\GeneralTrait;
use App\Traits\Stock\StockTrait;
use App\Models\Product;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\TransferDetail;
use App\Services\TransferService;
use App\Services\CoreService;

use App\Http\Controllers\Controller;
use DB;

class TransferController extends Controller
{

    use TemporaleTrait,
        StockTrait,
        StoreProductTrait,
        DetailsTrait,
        GeneralTrait;

    public function __construct(
        protected StockRepositoryInterface $stock,
        protected DetailRepositoryInterface $details,
        protected TransferService $transfer,
        protected CoreService $core,
        protected InventureService $inventure
    ) {
        // $this->inventury = $inventury;
        $this->stock = $stock;
        $this->details = $details;
        $this->transfer = $transfer;
        $this->core = $core;
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

    public function get_product(Request $request)
    {




        if ($request->post('type') == 'store') {

            $products = StoreProduct::where('store_products.quantity', '!=', 0)->where('product_units.unit_type', '==', 0)
                ->where('store_products.store_id', $request->post('id'))
                // ->joinall()
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
                    'products.rate',
                    'statuses.name as status',
                    'stores.text as store'
                )
                ->get();
        } else {
            $products = StoreProduct::where('store_products.quantity', '!=', 0)->where('product_units.unit_type', '==', 0)
                ->where('store_products.product_id', $request->post('id'))
                // ->joinall()
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
                    'products.rate',
                    'statuses.name as status',
                    'stores.text as store'
                )
                ->get();
        }
        // $retVal = ($request->type == 'product') ? a : b ;


        $this->units($products);
        return response()->json(['products' => $products]);
    }




    public function data_for_transfer()
    {

        $products = Product::all();
        return response()->json(['products' => $products]);
    }





    public function store(Request $request)
    {



        $this->core->data = $request->all();
        try {

            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            $this->stock->add();

            foreach ($request->post('count') as $value) {
                $this->core->value  = $value;

                // if ($value !== null) {

                $this->stock->decode_unit()->convert_qty();

                $this->transfer->store();

                $this->details->init_details(); // this make initial for details tables

                $this->transfer->stock();


                // }


            }

            // dd('f');

            // ---------------------------------------------------------------------------------------

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
            ->select('products.*', 'units.name as unit', 'transfer_details.*', 'statuses.*', 'statuses.name as status', 'stores.*')
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

        $transfer_details = TransferDetail::where('transfer_details.transfer_id', $id)
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
}
