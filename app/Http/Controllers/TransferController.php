<?php

namespace App\Http\Controllers;

use App\Traits\TemporaleTrait;
use App\Traits\StoreTrait;
use App\Traits\StockTrait;
use App\Traits\StoreProductTrait;
use App\Traits\DetailsTrait;

use App\Models\Product;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\TransferDetail;

use DB;

class TransferController extends Controller
{

    use TemporaleTrait, StoreTrait, StockTrait, StoreProductTrait,DetailsTrait;

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



        $products = StoreProduct::where('store_products.quantity', '!=', 0)
            ->where('store_products.product_id', $request->post('product'))
            ->joinall()
            // ->join('products', 'products.id', '=', 'store_products.product_id')
            // ->join('stores', 'stores.id', '=', 'store_products.store_id')
            // ->join('statuses', 'statuses.id', '=', 'store_products.status_id')
            ->select('store_products.quantity', 'store_products.*', 'products.id', 'products.text as product', 'statuses.name as status', 'stores.text as store')
            ->get();



        // $stores = DB::table('shelves')
        //     ->join('stores', 'shelves.store_id', '=', 'stores.id')
        //     ->select('shelves.*','stores.id as store_id', 'stores.code')
        //     ->get();

        return response()->json(['products' => $products]);
    }




    public function data_for_transfer()
    {

        $products = Product::all();
        return response()->json(['products' => $products]);
    }





    public function store(Request $request)
    {



        $transfer = new Transfer();
        $transfer->date =  $request->post('date');
        $transfer->save();
       
        foreach ($request->post('count') as $value) {


            if ($value !== null) {

                $stock_f = 0;
                $store_product_f = 0;
                $store_product_f = $this->refresh_store($value,'transfer','decrement',$request->all());
                $store_product_f = $this->refresh_store($value,'transfer','transfer_increment',$request->all());
                //  --------------------------------------------------------------------------
                $id_store_product = $this->get($value,'transfer',$request->all());
                

                foreach ($id_store_product as $values) {


                    $id_store_product = $values['id'];
                }

                if ($store_product_f == 0) {

                    $id_store_product = $this->init_store($value,'transfer','dssds',$request->all());
                    // return response()->json(['rrx' =>$id_store_product ]);
                   
                }




                // --------------------------------------------------------------------------------------------------------------

                // return response()->json(['rrxxxx' => $request->all()['product_id'][$value]]);
                $this->init_details($transfer->id,$id_store_product,$value,'transfer',$request->all());
             
                // --------------------------------------------------------------------------------------------------------------
                $stock_f = $this->refresh_stock($transfer->id, $value, 'transfer', 'increment',$request->all());
                // -----------------------------------------------------


                if ($stock_f == 0) {


                    $this->init_stock($transfer->id, $value, 'transfer', $request->post('date'),$request->all());
                }
            }


        }
        return response()->json(['message' => 'success']);
    }

    public function show(Request $request)
    {

        // $transfer_details =  TransferDetail::where('status', '0')->get();


        $transfer_details = TransferDetail::jointransfer()
            // ->join('products', 'transfer_details.product_id', '=', 'products.id')
            // ->join('statuses', 'transfer_details.status_id', '=', 'statuses.id')
            // ->join('stores', 'transfer_details.store_id', '=', 'stores.id')
            ->select('products.*', 'transfer_details.*', 'statuses.*', 'statuses.name as status', 'stores.*')
            ->get();


        return response()->json(['transfer_details' => $transfer_details]);
    }

    public function details_transfer($id)
    {

        $transfer_details = TransferDetail::where('transfer_details.transfer_id', $id)
            ->jointransfer()
            // ->join('products', 'transfer_details.product_id', '=', 'products.id')
            // ->join('statuses', 'transfer_details.status_id', '=', 'statuses.id')
            // ->join('stores', 'transfer_details.store_id', '=', 'stores.id')
            ->select('transfer_details.*', 'products.text as product', 'statuses.name as status', 'stores.text as store')
            ->get();


        return response()->json(['transfer_details' => $transfer_details]);
    }
}
