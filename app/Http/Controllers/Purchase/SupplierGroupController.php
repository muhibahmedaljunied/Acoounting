<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Http\Request;
use App\Services\SupplierService;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\Account;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Storage;

class SupplierGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $groups =  DB::table('groups')
            ->join('group_types', 'group_types.id', '=', 'groups.group_type_id')
            ->where('group_types.code', 'supplier')
            ->select(
                'groups.*',
                'group_types.name as type_name'
            )
            ->get();

        return response()->json(['groups' => $groups]);
    }
}
