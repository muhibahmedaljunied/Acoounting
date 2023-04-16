<?php

namespace App\Traits\Return;
use App\Models\SupplyReturn;
use App\Models\CashReturn;
use App\Models\SaleReturn;
use App\Models\PurchaseReturn;


use DB;

trait ReturnTrait
{

    // public function __construct()
    // {

    // }

    function store_return($request)
    {

        $tables = '';
        switch ($request['type']) {


            case 'SupplyReturn':
                $return = new SupplyReturn();
                $return->supply_id = $request['id']; #this equal supply_id
                $tables = 'supplies';

                break;

            case 'CashReturn':

                $return = new CashReturn();
                $return->cash_id = $request['id']; #this equal cash_id
                $tables = 'cashes';
                break;
            case 'PurchaseReturn':

                $return = new PurchaseReturn();
                $return->purchase_id = $request['id'];
                $tables = 'purchases';
                break;

            case 'SaleReturn':

                $return = new SaleReturn();
                $return->sale_id = $request['id'];
                $tables = 'sales';

                break;

            default:
                break;
        }

        $return->date  = $request['date'];
        // $return->quantity = $request->post('total');
        $return->note  = $request['note'];
        $return->save();

        return $return;


           
    }




    function check_detail($type)
    {
            // $detail = 0;

            $detail = DB::table('purchase_return_details')
                ->select('purchase_return_details.*')
                ->get();
       



        return $detail;
    }





}
