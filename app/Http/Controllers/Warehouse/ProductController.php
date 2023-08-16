<?php

namespace App\Http\Controllers\Warehouse;

use App\Models\Product;
use App\Models\store;
use App\Models\ProductUnit;
use App\Exports\ProductExport;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('Admin');


    }
    public function index(Request $request)
    {


    }

    public function search(Request $request)
    {


        $products = Product::where('products.name', 'LIKE', '%' . $request->post('word_search') . '%')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('group_categories', 'group_categories.id', '=', 'categories.group_id')
            ->select('products.*', 'categories.name as category_name', 'group_categories.name as group_name')
            ->paginate(10);
        return response()->json($products);
    }

    public function tree_product()
    {


        $products = Cache::rememberForever('tree_product_products',function(){

            return Product::where('parent_id', null)->with('children')->get();

        });

        $last_nodes = Cache::rememberForever('tree_product_last_nodes',function(){

            return Product::where('parent_id', null)->select('products.*')->max('id');

        });

        return response()->json(['trees' => $products, 'last_nodes' => $last_nodes]);
    }





    public function create()
    {
    }

    public function store(Request $request)
    {



        // $validator = Validator::make($request->all(), [
        //     'text' => 'required',
        //     'hash_rate' => 'required',
        //     'purchase_price' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 401);
        // }

        // -------------------------------------------------------


        // return response()->json($request->all());
        $file_name = '';
        if ($request->file('image') != 0) {


            $file = $request->file('image');
            $upload_path = public_path('assets/upload');
            $file_name = $file->getClientOriginalName();
            $generated_new_name = time() . '.' . $file->getClientOriginalExtension();
            $file->move($upload_path, $file_name);
        }

        $product = new Product();
        $product->text = $request->post('text');
        if ($request->post('parent') != 0) {
            $product->parent_id = $request->post('parent');
        }
        $product->id = $request->post('product_id');
        $product->rank = $request->post('rank');
        $product->product_minimum = $request->post('product_minimum');
        $product->status = $request->post('status');
        $product->rate = $request->post('hash_rate');

        $product->image = $file_name;
        $product->save();


        // return response()->json($request->all());

        if ($request->post('status') == 'false') {

            $product_unit = new ProductUnit();
            $product_unit->unit_id = $request->post('unit');
            $product_unit->product_id = $product->id;
            $product_unit->purchase_price = $request->post('purchase_price');
            $product_unit->unit_type = 1;

            $product_unit->save();


            if ($request->post('retail_unit')) {

                $product_unit = new ProductUnit();
                $product_unit->unit_id = $request->post('retail_unit'); 
           
                $product_unit->product_id = $product->id;
                $product_unit->purchase_price = $request->post('purchase_price_for_retail_unit');
                // $product_unit->rate = $request->post('hash_rate');
                $product_unit->unit_type = 0;

                $product_unit->save();

                // return response()->json($value);
            }
        }


        Cache::forget('tree_product_products');
        Cache::forget('tree_product_last_nodes');
        Cache::forget('stock');

        


        return response()->json($request->file('image'));
    }


    public function product_details_node($id)
    {


        $details = DB::table('products')
            ->where('products.id', '=', $id)
            ->select('products.*')
            ->get();


        $childs = Product::where('parent_id', $id)->select('products.*')->max('id');


        return response()->json(['childs' => $childs, 'details' => $details]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Product::find($id);
        return response()->json(['data' => $data]);
    }

    public function product_edit_node(Request $request, $id)
    {

        $data = Product::find($id);
        return response()->json(['data' => $data]);
    }

    public function product_update_node(Request $request, $id)
    {

        $data = Product::find($id);
        return response()->json(['data' => $data]);
    }

    public function product_rename_node(Request $request, $id)
    {

        $data = Product::find($id);
        $data->text = $request->post('text');
        $data->save();

        return response()->json($data);
    }


    // public function update(Request $request)
    // {

    //     // return response()->json($request);
    //     if ($request->post('image') != 0) {

    //         $file = $request->file('image');
    //         $upload_path = public_path('assets/upload');
    //         $file_name = $file->getClientOriginalName();
    //         $generated_new_name = time() . '.' . $file->getClientOriginalExtension();
    //         $file->move($upload_path, $file_name);
    //         // $request->merge(['image' => $file_name]);

    //     } else {

    //         $image = Product::find($request->id);


    //         $request->merge(['image' => $image->image]);
    //     }

    //     // return response()->json($image);
    //     // -----------------------------------------
    //     $product = Product::find($request->id);
    //     $product->update($request->post());
    //     return response()->json($request->file('image'));

    //     // ------------------------------------------

    // }


    public function destroy($id)
    {
        $product = Product::find($id);

        $product->delete();

        return response()->json('successfully deleted');
    }
}
