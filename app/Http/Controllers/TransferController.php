<?php

namespace App\Http\Controllers;

use App\Traits\Temporale\TemporaleTrait;
use App\Traits\GeneralTrait;
use App\Traits\Stock\StockTrait;
use App\Traits\StoreProduct\StoreProductTrait;
use App\Traits\Details\DetailsTrait;
// use App\Facades\Returns;
use App\Models\Product;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\TransferDetail;

use DB;

class TransferController extends Controller
{

    use TemporaleTrait,
        StockTrait,
        StoreProductTrait,
        DetailsTrait,
        GeneralTrait;


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



        $products = StoreProduct::where('store_products.quantity', '!=', 0)->where('product_units.unit_type', '==', 0)
            ->where('store_products.product_id', $request->post('product'))
            // ->joinall()
            ->join('products', 'products.id', '=', 'store_products.product_id')
            ->join('stores', 'stores.id', '=', 'store_products.store_id')
            ->join('statuses', 'statuses.id', '=', 'store_products.status_id')
            ->join('product_units', 'product_units.product_id', '=', 'products.id')
            ->join('units', 'units.id', '=', 'product_units.unit_id')
            ->select('store_products.quantity', 'store_products.*', 'units.name as unit', 'products.id', 'products.text as product', 'products.rate', 'statuses.name as status', 'stores.text as store')
            ->get();

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


        try {

            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction
            // ---------------------------------------------------------------------------------------

            $transfer_id =  $this->add_start(data: $request->all());
            $data = $request->all();

            foreach ($request->post('count') as $value) {


                $data = array_merge($request->except(['old']), $request['old'][$value]);
                $qty_after_convert = $this->check_return($data);
                if ($qty_after_convert['message'] == 0) {

                    return response()->json(['message' => 0, 'text' => $qty_after_convert['text']]);
                }

                $data['qty'] = $qty_after_convert['qty_transfer'];


                // dd($data);
                if ($value !== null) {

                    $stock_f = 0;
                    $store_product_f = 0;
                    $store_product_f = $this->refresh_store(
                        data: $data,
                        type_refresh: 'decrement',
                    );

                    $store_product_f = $this->refresh_store(

                        data: $data,
                        type_refresh: 'increment',
                        store_id: $data['intostore_id'][$value]


                    );


                    //  --------------------------------------------------------------------------

                    $id_store_product = $this->get($data);

                    // exit();

                    if ($store_product_f == 0) {

                        $id_store_product = $this->init_store(
                            data: $data,
                            store_id: $data['intostore_id'][$value]
                        );
                    }

                    // --------------------------------------------------------------------------------------------------------------

                    $r = $this->init_details(
                        id: $transfer_id,
                        id_store_product: $id_store_product,
                        data: $data,
                        unit_id: $data['unit_selected'][0]
                    );

                    // --------------------------------------------------------------------------------------------------------------
                    $stock_f = $this->refresh_stock(
                        id: $transfer_id,
                        type_refresh: 'increment',
                        data: $data
                    );
                    // -----------------------------------------------------

                    if ($stock_f == 0) {

                        $this->init_stock(
                            id: $transfer_id,
                            data: $data
                        );
                    }
                }
            }
            // dd('s');

            // ---------------------------------------------------------------------------------------

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
        // return response([
        //     'message' => '$exp->getMessage()',
        //     'status' => 'success'
        // ], 400);
    }


    public function check_return($value)
    {

        // return $value['qty_transfer'];
        $qty_transfer = $value['qty_transfer'];
        $qty = $value['quantity'];
        foreach ($value['units'] as $key => $values) {   //this for converts qty_return into micro unit

            if ($value['unit_selected'][2] == 1) {


                $qty_transfer = $value['qty_transfer'] * $value['rate'];
            }
        }


        // -------------------------------------------------------------------------------------------------------------------
        if ($qty_transfer > $qty) {
            return ['message' => 0, 'text' => "لا يمكنك تحويل كميه اكبر من  الكميه المتوفره"];
        }


        return ['message' => 1, 'qty_transfer' => $qty_transfer];
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
            ->select('products.*', 'transfer_details.*', 'units.name as unit', 'products.text as product', 'statuses.name as status', 'stores.text as store')
            ->get();
        $this->units($transfer_details);


        return response()->json(['transfer_details' => $transfer_details]);
    }

    // function set_unit($request, $value, $array_unit_after_decode)
    // {

    //     if ($array_unit_after_decode[2] == 0) {  //this means unit_type

    //         $micro_unit_qty = $request['qty'][$value];
    //     } else {

    //         $micro_unit_qty = $request['qty'][$value] * $array_unit_after_decode[1];
    //     }

    //     return $micro_unit_qty;
    // }




}
