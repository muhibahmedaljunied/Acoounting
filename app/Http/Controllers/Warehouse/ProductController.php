<?php

namespace App\Http\Controllers\Warehouse;
use Illuminate\Support\Facades\Validator;
use App\Services\Product\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use App\Exports\ProductExport;
use App\Models\Status;
use App\Models\Product;
use Illuminate\Http\Request;

use DB;
class ProductController extends Controller
{
 
    public function __construct(protected ProductService $product)
    {
        // $this->middleware('Admin');


    }
    public function index(Request $request)
    {
    }

    // public function import(Request $request)
    // {
    //     $file = $request->file('file');
    //     Excel::import(new Status, $file);
    //     return back()->with('success', 'Products imported successfully.');
    // }

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


        $products = Cache::rememberForever('tree_product_products', function () {

            return Product::where('parent_id', null)->with('children')->get();
        });

        $last_nodes = Cache::rememberForever('tree_product_last_nodes', function () {

            return Product::where('parent_id', null)->select('products.*')->max('id');
        });

        return response()->json(['trees' => $products, 'last_nodes' => $last_nodes]);
    }



    public function import(Request $request)
    {
   
        Excel::import(new ProductImport, storage_path('product.xlsx'));

        return response()->json([
            'status' =>
            'The file has been excel/csv imported to database in laravel 9'
        ]);

    }

   
    public function export()
    {

        return Excel::download(new ProductExport, 'product.xlsx');
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

       
       
        $this->product->check()->product()->unit();

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
