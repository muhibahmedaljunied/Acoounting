<?php

namespace App\Http\Controllers;

use App\Traits\Temporale\TemporaleTrait;
use App\Traits\StoreProduct\StoreTrait;
use App\Traits\Stock\StockTrait;
use App\Traits\StoreProduct\StoreProductTrait;
use App\Traits\Details\DetailsTrait;

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



        $products = StoreProduct::where('store_products.quantity', '!=', 0)->where('product_units.unit_type','==',0)
            ->where('store_products.product_id', $request->post('product'))
            // ->joinall()
            ->join('products', 'products.id', '=', 'store_products.product_id')
            ->join('stores', 'stores.id', '=', 'store_products.store_id')
            ->join('statuses', 'statuses.id', '=', 'store_products.status_id')
            ->join('product_units', 'product_units.product_id', '=', 'products.id')
            ->join('units', 'units.id', '=', 'product_units.unit_id')
            ->select('store_products.quantity', 'store_products.*','units.name as unit', 'products.id', 'products.text as product','products.rate', 'statuses.name as status', 'stores.text as store')
            ->get();

        foreach ($products as $value) {

            $units = DB::table('product_units')
                ->join('units', 'units.id', '=', 'product_units.unit_id')
                ->join('products', 'products.id', '=', 'product_units.product_id')
                ->where('product_units.product_id', $value->product_id)
                ->select('units.*','products.rate','product_units.unit_type')
                ->get();

            $value->units = $units;
        }     



  

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

              

                $array_unit_after_decode =$request['unit_id'][$value];
                $micro_unit_qty = $this->set_unit($request,$value,$array_unit_after_decode);
                // return response()->json(['rrx' =>$micro_unit_qty]);
                $store_product_f = $this->refresh_store_from_transfer($value,$request->all(),$micro_unit_qty,'decrement');

                $store_product_f = $this->refresh_store_from_transfer($value,$request->all(),$micro_unit_qty,'increment');
               
                //  --------------------------------------------------------------------------
                $id_store_product = $this->get($value,$request->all());
                // return response()->json(['rrx' =>$id_store_product ]);
                foreach ($id_store_product as $values) {

                    // return response()->json(['rrx' =>$values['id'] ]);
                    $id_store_product = $values['id'];
                }

                if ($store_product_f == 0) {

                    $id_store_product = $this->init_store($value,'Transfer',$request->all(),$micro_unit_qty);
                   
                }

                
                // return response()->json(['rrx' =>$id_store_product ]);
                // --------------------------------------------------------------------------------------------------------------

                $r = $this->init_details($transfer->id,$id_store_product,$value,'Transfer',$request->all());

                // return response()->json(['rrx' =>$r ]);
                // --------------------------------------------------------------------------------------------------------------
                $stock_f = $this->refresh_stock($transfer->id, $value, 'Transfer', 'increment',$request->all());
                // -----------------------------------------------------

                // return response()->json(['rrx' =>$stock_f ]);
                if ($stock_f == 0) {


                    $this->init_stock($transfer->id, $value, 'Transfer', $request->post('date'),$request->all());
                }
            }


        }
        return response()->json(['message' => 'success']);
    }

    public function show(Request $request)
    {

        // $transfer_details =  TransferDetail::where('status', '0')->get();
        // ->join('store_products', 'store_products.id', '=', $table.'.store_product_id')
        // ->join('products', $table.'.product_id', '=', 'products.id')
        // ->join('statuses', $table.'.status_id', '=', 'statuses.id')
        // ->join('stores', $table.'.store_id', '=', 'stores.id')
        // ->join('units', $table.'.unit_id', '=', 'units.id')
        // ->select('products.*', 'products.text as product', 'units.name as unit', $table.'.*', 'statuses.name as status', 'stores.text as store', 'store_products.quantity as avilable_qty', 'store_products.desc', DB::raw($table.'.qty-' . $table.'.qty_return AS qty_remain'))
        // ->get();


        $transfer_details = DB::table('transfer_details')
            ->join('products', 'transfer_details.product_id', '=', 'products.id')
            ->join('statuses', 'transfer_details.status_id', '=', 'statuses.id')
            ->join('stores', 'transfer_details.store_id', '=', 'stores.id')
            ->join('units', 'transfer_details.unit_id', '=', 'units.id')
            ->select('products.*','units.name as unit', 'transfer_details.*', 'statuses.*', 'statuses.name as status', 'stores.*')
            ->get();

        $this->units($transfer_details);
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

    function set_unit($request,$value,$array_unit_after_decode){

        if($array_unit_after_decode[2] == 0){  //this means unit_type

            $micro_unit_qty = $request['qty'][$value];
        }else{

            $micro_unit_qty = $request['qty'][$value]*$array_unit_after_decode[1]; 
        }

        return $micro_unit_qty;

    }

    // public function unit ($request,$value){

        
    //     foreach ($request['old'] as $key => $values) {   //this for converts qty_avaliable into big unit

    //         $micro_unit_qty = $request['qty'][$value];

    //         if($values['units'][$value]['name'] == $values['unit'] && $values['units'][$value]['unit_type'] == 1){

                    
    //              $micro_unit_qty = $request['qty'][$value]*$request['unit_id'][$value][1]; 
    
    //         }

    //         if($values['units'][$value]['name'] == $values['unit'] && $values['units'][$value]['unit_type'] == 0){

                    
    //               $micro_unit_qty = $request['qty'][$value];
    
    //         }

    //     }

    //     return $micro_unit_qty;




    // }
}
