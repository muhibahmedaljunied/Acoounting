<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\store;
use App\Models\ProductUnit;
use App\Exports\ProductExport;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

use Illuminate\Http\Request;
use DB;
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


        $products = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('group_categories', 'group_categories.id', '=', 'categories.group_id')
            ->select('products.*', 'categories.name as category_name', 'group_categories.name as group_name')
            // ->select('store_products.*')
            ->paginate(10);
        return response()->json($products);
    }

    public function search(Request $request)
    {



        // $products = StoreProduct::where('products.name', 'LIKE', '%'.$request->post('word_search').'%')
        //     ->join('stores','store_products.store_id', '=', 'stores.id')
        //     ->join('products','store_products.product_id', '=', 'products.id')
        //     ->join('categories','products.category_id', '=', 'categories.id')
        //     ->join('group_categories','group_categories.id', '=', 'categories.group_id')
        //     ->select('products.*','categories.name as category_name','stores.code as code_store','group_categories.name as group_name')
        //     ->paginate(10);
        //     return response()->json($products);


        $products = Product::where('products.name', 'LIKE', '%' . $request->post('word_search') . '%')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('group_categories', 'group_categories.id', '=', 'categories.group_id')
            ->select('products.*', 'categories.name as category_name', 'group_categories.name as group_name')
            ->paginate(10);
        return response()->json($products);
    }

    public function tree_product()
    {

        $products = Product::where('parent_id', null)->with('children')->get();
        $last_nodes = Product::where('parent_id', null)->select('products.*')->max('id');
        return response()->json(['products' => $products, 'last_nodes' => $last_nodes]);
    }



    // -------------------------------------------------------------------
    // public function getProductDetails($id)
    // {
    //     $Product = DB::table('products')
    //         ->join('categories', 'products.category_id', '=', 'categories.id')
    //         ->where('products.id', '=', $id)
    //         ->select('products.*', 'categories.name as category_name')
    //         ->first();

    //     //$data = $Product->toArray();
    //     //var_dump($Product);
    //     return response()->json($Product);
    // }


    public function product_Store_first_level(Request $request)
    {

        $Store = new Product();
        $Store->text = $request->post('text');
        $Store->id = $request->post('id');

        $Store->rank = 1;
        $Store->save();

        return response()->json();
    }

    // ---------------------------------------------------------------------
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $category = Category::all();


        $store = Store::all();


        return response()->json(['category' => $category, 'store' => $store]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store_first_level(Request $request)
    {


        $file_name = '';
        if ($request->file('image') != 0) {


            $file = $request->file('image');
            $upload_path = public_path('assets/upload');
            $file_name = $file->getClientOriginalName();
            $generated_new_name = time() . '.' . $file->getClientOriginalExtension();
            $file->move($upload_path, $file_name);
        }

        $product = new Product();
        $product->text = $request->post('product');
        $product->id = $request->post('id');

        $product->rank = $request->post('rank');
        $product->image = $file_name;
        // $product->image = $generated_new_name;

        $product->save();

        return response()->json($request->file('image'));
    }

    public function store(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'text' => 'required',
            'hash_rate' => 'required',
            'purchase_price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        // -------------------------------------------------------



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

        $product->image = $file_name;
        $product->save();


        // return response()->json($request->all());

        if ($request->post('status') == 'false') {

            $product_unit = new ProductUnit();
            $product_unit->unit_id = $request->post('unit');
            $product_unit->product_id = $product->id;
            $product_unit->purchase_price = $request->post('purchase_price');
            $product_unit->save();


            if ($request->post('retail_unit')) {

                $product_unit = new ProductUnit();
                $product_unit->unit_id = $request->post('retail_unit');
                $product_unit->product_id = $product->id;
                $product_unit->purchase_price = $request->post('purchase_price_for_retail_unit');
                $product_unit->rate = $request->post('hash_rate');
                $product_unit->save();

                // return response()->json($value);
            }
        }


        // ------------this for ProductUnit--------------


        // ------------------------

        return response()->json($request->file('image'));
    }

    public function Export()
    {
        $filename = '-products.xlsx';
        Excel::store(new ProductExport, $filename);
        $fullPath = Storage::disk('local')->path($filename);

        return response()->json([
            'data' => $fullPath,
            'message' => 'stores are successfully exported.'
        ], 200);
    }

    public function Import(Request $request)
    {

        $filename = '-products.xlsx';
        return response()->json(Excel::import(new ProductImport, Storage::disk('local')->path($filename)));
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
