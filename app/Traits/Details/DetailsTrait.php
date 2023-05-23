<?php

namespace App\Traits\Details;

use DB;
use App\Traits\Unit\UnitsTrait;
use App\Models\TransferDetail;
use App\Models\SaleDetail;
use App\Models\PurchaseDetail;
use App\Models\AttendanceDetail;
use App\Models\SupplyDetail;
use App\Models\CashDetail;
use App\Models\SaleReturnDetail;
use App\Models\PurchaseReturnDetail;
use App\Models\SupplyReturnDetail;
use App\Models\CashReturnDetail;
use App\Models\OpeningInventury;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\PseudoTypes\LowercaseString;

trait DetailsTrait
{
    use UnitsTrait;



    function init_details($id_store_product,$data,$id=null,$unit_id = null)

    {
        // return $id_store_product;
        $unit_id = ($unit_id) ? $unit_id : $data['unit_id'] ;

        switch ($data['type']) {

            case 'Attendance':

                $Details = new AttendanceDetail();
                $Details->attendance_id = $id;
                $Details->period_id = $data['period_id'];
                $Details->status_attendance = $data['status_attendance'];

                if ($data['attendance_in_out'] == 1) {
                    $Details->check_in = $data['time_in'];
                } else {
                    $Details->check_out = $data['time_out'];
                }

                $Details->store_id = $data['check_in'];
                $Details->unit_id = $data['check_out'][0];

                $Details->duration = $data['duration'];
                $Details->delay = $data['delay'];
                $Details->leave = $data['leave'];
                $Details->save();
                return 1;
                break;

            case 'Transfer':

                $Details = new TransferDetail();
                $Details->transfer_id = $id;
                $Details->into_store = $data['intostore'];
                $Details->store_product_id = $id_store_product;
                $Details->product_id = $data['product_id'];
                $Details->status_id = $data['status_id'];
                $Details->store_id = $data['store_id'];
                $Details->unit_id = $unit_id;
                $Details->desc = $data['desc'];
                $Details->qty = $data['qty'];
                $Details->save();

                return 1;
                break;

            case 'Opening':
                // $unit = json_decode($data['unit_id']);
                // return $unit;
                $Details = new OpeningInventury();
                $Details->store_product_id = $id_store_product;
                $Details->product_id = $data['product_id'];
                $Details->status_id = $data['status_id'];
                $Details->store_id = $data['store_id'];
                $Details->unit_id = $unit_id;
                $Details->desc = $data['desc'];
                $Details->qty = $data['qty'];
                $Details->price = $data['price'];
                // $Details->expiry_date = $data['expiry_date'];
                                $Details->date = $data['date'];

                $Details->total = $data['total'];
                $Details->save();

                return 1;
                break;

            case ($data['type'] == 'SupplyReturn' || $data['type'] == 'CashReturn' || $data['type'] == 'SaleReturn' || $data['type'] == 'PurchaseReturn'):

                if ($data['type'] == 'SaleReturn') {
                    $Details = new SaleReturnDetail();
                    $Details->sale_return_id = $id;
                }
                if ($data['type'] == 'PurchaseReturn') {
                    $Details = new PurchaseReturnDetail();
                    $Details->purchase_return_id = $id;
                }
                if ($data['type'] == 'SupplyReturn') {
                    $Details = new SupplyReturnDetail();
                    $Details->supply_return_id = $id;
                }
                if ($data['type'] == 'CashReturn') {
                    $Details = new CashReturnDetail();
                    $Details->cash_return_id = $id;
                }
                $Details->store_product_id = $id_store_product;
                $Details->product_id = $data['product_id'];
                $Details->status_id = $data['status_id'];
                $Details->store_id = $data['store_id'];
                $Details->unit_id = $unit_id;
                $Details->desc = $data['desc'];
                $Details->qty = $data['qty'];
                $Details->save();
                return 1;
                break;

            case ($data['type'] == 'Purchase' || $data['type'] == 'Sale'):

                if ($data['type'] == 'Purchase') {
                    $Details = new PurchaseDetail();
                    $Details->purchase_id = $id;
                }
                if ($data['type'] == 'Sale') {
                    $Details = new SaleDetail();
                    $Details->sale_id = $id;
                }
                $Details->price = $data['price'];
                $Details->qty = $data['qty'];
                $Details->total = $data['sub_total'];
                break;

            case ($data['type'] == 'Supply' || $data['type'] == 'Cash'):

                if ($data['type'] == 'Supply') {
                    $Details = new SupplyDetail();
                    $Details->supply_id = $id;
                }
                if ($data['type'] == 'Cash') {
                    $Details = new CashDetail();
                    $Details->cash_id = $id;
                }
                break;
                // table ReturnSaleDetail and ReturnPurchaseDetail must to changes into  SaleReturnDetail and PurchaseReturnDetail
        }

        $Details->store_product_id = $id_store_product;
        $Details->product_id = $data['product_id'];
        $Details->status_id = $data['status_id'];
        $Details->store_id = $data['store_id'];
        $Details->unit_id = $unit_id;

        $Details->desc = $data['desc'];
        $Details->qty = $data['qty'];

        $Details->save();
    }


    function refresh_details(...$list_data)
    {

        $data = $list_data['data'];
        $after_update = str_replace('Return', '', $data['type']);

        $type_column = strtolower($after_update);

        $condition = [
            'product_id' => $data['product_id'],
            'status_id' => $data['status_id'],
            'store_id' => $data['store_id'],
            'desc' => $data['desc'],
            'id' => $data['id']
            // $type_column.'_id' => $data['id']
        ];
        DB::table($type_column.'_details')->where($condition)->increment('qty_return', $data['qty']);

        // switch ($data['type']) {

        //     case 'PurchaseReturn':
        //         PurchaseDetail::where($condition)->increment('qty_return', $data['qty']);

        //         // wherepurchase($request)->increment('qty_return', $request['qty'][$value]);
        //         break;
        //     case 'SaleReturn':
        //         SaleDetail::where($condition)->increment('qty_return', $data['qty']);
        //         break;

        //     case 'SupplyReturn':
        //         SupplyDetail::where($condition)->increment('qty_return', $data['qty']);
        //         break;

        //     case 'CashReturn':
        //         CashDetail::where($condition)->increment('qty_return', $data['qty']);
        //         break;
        // }
        // return $type_column;

    }



    public function details(Request $request, $id)
    {
        // return response()->json(['details' => $request->all()]);
        $table = $request->post('table');
        $output = explode('_', $table);
        $column = $output[0];

        //-----------------------------------------------------------------------------------------------
        $details =  DB::table($table)->where($table . '.' . $column . '_id', $id)
            // ->where('store_products.quantity', '!=', 0)
            ->join('store_products', 'store_products.id', '=', $table . '.store_product_id')
            ->join('products', $table . '.product_id', '=', 'products.id')
            ->join('statuses', $table . '.status_id', '=', 'statuses.id')
            ->join('stores', $table . '.store_id', '=', 'stores.id')
            ->join('units', $table . '.unit_id', '=', 'units.id')
            ->select('products.*', 'products.text as product', 'units.name as unit', $table . '.*', 'statuses.name as status', 'stores.text as store', 'store_products.quantity as avilable_qty', 'store_products.desc', DB::raw($table . '.qty-' . $table . '.qty_return AS qty_remain'))
            ->get();

        foreach ($details as $value) {

            $value->qty_return_now = 0;
            $value->unit_selected = [];
        }
        $this->units($details);


        



        return response()->json([$table => $details]);
    }
}
