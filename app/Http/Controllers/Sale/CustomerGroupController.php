<?php

namespace App\Http\Controllers\Sale;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\Account;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class CustomerGroupController extends Controller
{

    public function index()
    {

        $groups =  DB::table('groups')
        ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
        ->where('group_types.code','customer')
        ->select(
            'groups.*',
            'group_types.name as type_name'
        )
        ->get();

    return response()->json(['groups' => $groups]);



    }

  
}
