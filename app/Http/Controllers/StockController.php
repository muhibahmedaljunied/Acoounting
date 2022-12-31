<?php

namespace App\Http\Controllers;

use App\Stock;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use DB;

class StockController extends Controller
{
    
    public function index()
    {

        
        $stocks = StoreProduct::where('store_products.quantity', '!=', 0)
            ->joinall()
            // ->join('products', 'store_products.product_id', '=', 'products.id')
            // ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
            // ->join('stores', 'store_products.store_id', '=', 'stores.id')
            ->select('store_products.quantity','store_products.*','products.id','products.text as product','statuses.name as status','stores.text as store')
            ->paginate(10);

     
        return response()->json($stocks);
    }

    public function search(Request $request)      
    {      
        

        $stocks = StoreProduct::where('products.text', 'LIKE', '%'.$request->post('word_search').'%')
        ->where('store_products.quantity', '!=', 0)
        ->joinall()
            ->select('store_products.quantity','store_products.*','products.id','products.text as product','statuses.name as status','stores.text as store')
            ->paginate(10);

     
        return response()->json($stocks);

        

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       

        $size = new Stock([

            'quantity' => $request->post('quantity'),
            'price' => $request->post('price'),
            'unit_id' => $request->post('unit_id'),
            'product_id' => $request->post('product_id'),
            'store_id' => $request->post('store_id'),
        ]);

        $size->save();

        return response()->json('successfully added');
    }


    public function show(Stock $stock)
    {
        //
    }

    public function edit(Stock $stock)
    {
        //
    }

 
    public function update(Request $request, Stock $stock)
    {
        //
    }


    public function destroy(Stock $stock)
    {
        //
    }
}
