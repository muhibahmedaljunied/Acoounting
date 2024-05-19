<?php

namespace App\Http\Controllers\Staff;

use App\Exports\AdministrativeStructureExport;
use App\Http\Controllers\Controller;
use App\Imports\AdministrativeStructureImport;
use App\Models\AdministrativeStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdministrativeStructureController extends Controller
{

    public function index()
    {

        $stores = DB::table('administrative_structures')
            ->select('administrative_structures.*')
            ->paginate(10);
        return response()->json($stores);
    }

    public function search(Request $request)
    {
        $stores = AdministrativeStructure::where('administrative_structures.text', 'LIKE', '%' . $request->post('word_search') . '%')
            ->select('administrative_structures.*')
            ->paginate(10);
        return response()->json($stores);
    }

    public function tree_structure()
    {
         // ------------------------------------------------------------------------------------------------
         $stores = Cache::rememberForever('AdministrativeStructure', function () {
            return AdministrativeStructure::where('parent_id', null)->with('children')->get();
        });

          $last_nodes = Cache::rememberForever('last_nodes', function () {
            return AdministrativeStructure::where('parent_id', null)->select('administrative_structures.*')->max('id');
        });
        // --------------------------------------------------------------------------------------------------
        return response()->json(['trees' => $stores, 'last_nodes' => $last_nodes]);


        


            

    }

    public function import(Request $request)
    {

        Excel::import(new AdministrativeStructureImport, storage_path('structure.xlsx'));

        return response()->json([
            'status' =>
            'The file has been excel/csv imported to database in laravel 9'
        ]);
    }


    public function export()
    {

        return Excel::download(new AdministrativeStructureExport, 'structure.xlsx');
    }
    

    public function structure_details_node($id)
    {


        $details = DB::table('administrative_structures')
            ->where('administrative_structures.id', '=', $id)
            ->select('administrative_structures.*')
            ->get();


        $childs = AdministrativeStructure::where('parent_id', $id)->select('administrative_structures.*')->max('id');


        return response()->json(['childs' => $childs, 'details' => $details]);
    }

  
    public function store(Request $request)
    {


        // return response()->json($request->all());

    
        $Store = new AdministrativeStructure();
        $Store->text = $request->post('text');
        if($request->post('parent') != 0){
            $Store->parent_id= $request->post('parent');
        }
        $Store->id = $request->post('structure_id');
        $Store->rank = $request->post('rank');
        $Store->status = $request->post('status');
        $Store->save();
        Cache::forget('AdministrativeStructure');
        Cache::forget('last_nodes');


        return response()->json($request);
    }
    public function Store_details_node($id)
    {


        $details = DB::table('administrative_structures')
            ->where('Stores.id', '=', $id)
            ->select('Stores.*')
            ->get();


        $childs = AdministrativeStructure::where('parent_id', $id)->select('administrative_structures.*')->max('id');


        return response()->json(['childs' => $childs, 'details' => $details]);
    }
 
   
    public function update(Request $request)
    {
        $store = AdministrativeStructure::find($request->id);
        $store->update($request->post());
        return response()->json($request->post());
    }


    public function destroy($id)
    {
        $store = AdministrativeStructure::find($id);

        $store->delete();

        return response()->json('successfully deleted');
    }
}
