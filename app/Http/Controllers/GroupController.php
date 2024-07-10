<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class GroupController extends Controller
{

    public function index()
    {

        //     $groups =  DB::table('groups')
        //     ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
        //     ->where('group_types.code','customer')
        //     ->select(
        //         'groups.*',
        //         'group_types.name as type_name'
        //     )
        //     ->get();

        // return response()->json(['groups' => $groups]);



    }

    public function store_account_setting(Request $request)
    {

        // dd($request->all());
        $group_accounts = Group::find($request['group_id']);

        $group_accounts->update(['account_id' => $request['account_id']]);


        return response()->json(['message' => 'sucess']);
    }


    public function get_groups()
    {


        $groups =  DB::table('groups')
            ->join('group_types', 'groups.group_type_id', '=', 'group_types.id')
            ->select(
                'groups.*',
                'group_types.name as type_name',


            )

            ->get();

        $group_types =  DB::table('group_types')->select(
            'group_types.name as type_name',
            'group_types.id as group_type_id'
        )
            ->get();
        return response()->json(['groups' => $groups, 'group_types' => $group_types]);
    }


    public function store(Request $request)
    {




        foreach ($request['count'] as $value) {

            $groups = new Group();
            $groups->name = $request->name[$value];
            $groups->group_type_id = $request->type[$value];
            // $Details->total = $this->core->data['total'][$this->core->value];
            $groups->save();
        }

        return response()->json(['groups' => $groups]);
    }
}
