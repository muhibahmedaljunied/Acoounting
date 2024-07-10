<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Support\Facades\Cache;
use App\Models\Stock;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use App\Traits\Unit\UnitsTrait;
use App\Http\Controllers\Controller;
use App\Repository\Qty\QtyStockRepository;
use App\RepositoryInterface\QtyRepositoryInterface;


class StockController extends Controller
{

    use UnitsTrait;
    

    public function index(QtyStockRepository $qty)
    {

        $qty->compare_array = ['quantity'];
        $qty->details = Cache::rememberForever('stock', function () {

            return StoreProduct::where('store_products.quantity', '!=', 0)
            ->where('product_units.unit_type', '==', 0)
                ->join('statuses', 'store_products.status_id', '=', 'statuses.id')
                ->join('stores', 'store_products.store_id', '=', 'stores.id')
                ->join('products', 'store_products.product_id', '=', 'products.id')
                ->join('product_units', 'product_units.product_id', '=', 'products.id')
                ->join('units', 'units.id', '=', 'product_units.unit_id')
                ->select('store_products.quantity',
                 'store_products.*', 
                 'products.id', 
                 'products.text as product', 
                //  'products.rate', 
                 'product_units.rate', 
                 'statuses.name as status',
                 'stores.text as store', 
                 'units.name as unit')
                ->paginate(100);


        });
        
        $qty->handle_qty();



        return response()->json(['stocks' => $qty->details]);
    }



    public function search(Request $request)
    {


        $stocks = StoreProduct::where('products.text', 'LIKE', '%' . $request->post('word_search') . '%')
            ->where('store_products.quantity', '!=', 0)
            ->joinall()
            ->select('store_products.quantity', 
            'store_products.*', 
            'products.id', 
            'products.text as product', 
            'statuses.name as status', 
            'stores.text as store')
            ->paginate(10);


        return response()->json($stocks);
    }




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


  
    
}
