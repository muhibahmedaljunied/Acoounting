<?php

namespace App\Http\Controllers\Staff;

use App\Models\Store;
use App\Models\Staff;
use App\Models\AdministrativeStructures;
use App\Http\Controllers\Controller;

use Illuminate\Support\Benchmark;
use App\Models\AdministrativeStructure;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;


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


        
        // $staff_list =  staff::with([
        //     'qualification' => function ($query) {
        //         $query->select('*');
        //     },
        //     'branch' => function ($query) {
        //         $query->select('*');
        //     },
        //     'staff_type' => function ($query) {
        //         $query->select('*');
        //     },
        //     'work_type' => function ($query) {
        //         $query->select('*');
        //     },
        //     'staff_religion' => function ($query) {
        //         $query->select('*');
        //     },
        //     'nationality' => function ($query) {
        //         $query->select('*');
        //     }

        // ])
        //     ->paginate(10);


            // $staffs = DB::table('staff')
            // ->join('qualifications','qualifications.id', '=', 'staff.qualification_id')
            // ->join('branches','branches.id', '=', 'staff.branch_id')
            // ->join('staff_types','staff_types.id', '=', 'staff.staff_type_id')
            // ->join('work_types','work_types.id', '=', 'staff.work_type_id')
            // ->join('staff_religions','staff_religions.id', '=', 'staff.religion_id')
            // ->join('nationalities','nationalities.id', '=', 'staff.nationality_id')
            // ->select('staff.id','staff.email','staff.date','staff.name as staff','staff.staff_status as status','staff.gender','staff.social_status','qualifications.name as qualification','branches.name  as branch','departments.name as department','jobs.name  as job','staff_types.name as staff_types','staff_religions.name as religion','nationalities.name as nationality')
            // ->paginate(10);

            

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
