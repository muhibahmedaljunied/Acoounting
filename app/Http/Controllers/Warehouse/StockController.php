<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Support\Facades\Cache;
use App\Models\Stock;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use App\Traits\Unit\UnitsTrait;
use DB;
use App\Http\Controllers\Controller;
use stdClass;

class StockController extends Controller
{

    use UnitsTrait;
    
    public $units;
    public $value;
    public $key;

    public $quantity = 0;
    public $r = array(

        array(
            
        )
    );
    // public $r = array(
    //     array(

    //     )
    // );
    // public $fx = array();
    public function index()
    {


        $stocks = Cache::rememberForever('stock', function () {

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
        
        foreach ($stocks as $key => $value) {

            $this->value = $value;
            $this->units();
            $this->convert_qty($value->quantity);
        }


        // $this->units($stocks);
      


        return response()->json(['stocks' => $stocks]);
    }


    public function convert_qty($qty)
    {


        $this->quantity = $qty;

        foreach ($this->units as $key2 => $value2) {



            if ($this->quantity / $value2->rate >= 1) {


                $this->r["$this->key"]["$key2"] = array(

                    // "$key2" => array(
                    [intval($this->quantity / $value2->rate), $value2->name]
                    // )
                );
            }

            if ($this->quantity % $value2->rate >= 1) {

                $this->quantity = $this->quantity % $value2->rate;
            } else {

                break;
            }

            // $this->divid_one($value2, $key);




        }

        $this->value->qty_after_convert = $this->r;
        // dd($this->r);
        $this->r = array(
            array()
        );
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
