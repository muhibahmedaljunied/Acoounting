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

    public function store()
    {

        $Details = new CashDetail();
        $Details->cash_id = $this->core->cash_id;
        $Details->price = $this->core->data['old'][$this->core->value]['price'];
        $Details->total = $this->core->data['total'][$this->core->value];
        $Details->store_product_id = $this->core->id_store_product;
        $Details->unit_id = $this->core->unit_value;
        $Details->qty = $this->core->micro_unit_qty;
        $Details->save();

    return response()->json(['groups' => $groups]);



    }


  
}
