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

    function init_details($id, $id_store_product, $value, $type, $data = null)
    {

        //  return $data['unit_id'][$value][0];
        // $column = lcfirst($type);
        // $table = $type.'Detail';
      


        // ----------------------------------------------------------------------
       
        

        switch ($type) {

            case 'Attendance':

                $Details = new AttendanceDetail();
                $Details->attendance_id = $id;
                $Details->period_id = $data['period_id'][$value];
                $Details->status_attendance = $data['status_attendance'][$value];
                $Details->store_id = $data['check_in'][$value];
                $Details->unit_id = $data['check_out'][$value][0];

                $Details->duration = $data['duration'][$value];
                $Details->delay = $data['delay'][$value];
                $Details->leave = $data['leave'][$value];
                $Details->save();

                return 1;
                break;

            case 'Transfer':

                $Details = new TransferDetail();
                $Details->transfer_id = $id;
                $Details->into_store = $data['intostore'][$value];
                $Details->store_product_id = $id_store_product;
                $Details->product_id = $data['product_id'][$value];
                $Details->status_id = $data['status_id'][$value];
                $Details->store_id = $data['store_id'][$value];
                $Details->unit_id = $data['unit_id'][$value][0];

                $Details->desc = $data['desc'][$value];
                $Details->qty = $data['qty'][$value];
                $Details->save();

                return 1;
                break;
            
            case 'Opening':
                $unit = json_decode($data['unit_id'][$value]);
                // return $unit;
                $Details = new OpeningInventury();
                $Details->store_product_id = $id_store_product;
                $Details->product_id = $data['product_id'][$value];
                $Details->status_id = $data['status_id'][$value];
                $Details->store_id = $data['store_id'][$value];
                $Details->unit_id = $unit[0];
                $Details->desc = $data['desc'][$value];
                $Details->qty = $data['qty'][$value];
                $Details->price = $data['price'][$value];
                $Details->expiry_date = $data['expiry_date'];
                $Details->total = $data['total'][$value];
                $Details->save();

                return 1;
                break;

            case ($type == 'SupplyReturn' || $type == 'CashReturn' || $type == 'SaleReturn' || $type == 'PurchaseReturn'):

                if($type == 'SaleReturn'){$Details = new SaleReturnDetail();$Details->sale_return_id = $id;}
                if($type == 'PurchaseReturn'){$Details = new PurchaseReturnDetail();$Details->purchase_return_id = $id;}
                if($type == 'SupplyReturn'){$Details = new SupplyReturnDetail();$Details->supply_return_id = $id;}
                if($type == 'CashReturn'){$Details = new CashReturnDetail();$Details->cash_return_id = $id;}
                $Details->store_product_id = $id_store_product;
                $Details->product_id = $data['product_id'][$value];
                $Details->status_id = $data['status_id'][$value];
                $Details->store_id = $data['store_id'][$value];
                $Details->unit_id = $data['unit_id'][$value][0];
                $Details->desc = $data['desc'][$value];
                $Details->qty = $data['qty'][$value];
                $Details->save();
                return;
                break;            

            case ($type == 'Purchase' || $type == 'Sale'):

                if($type == 'Purchase'){$Details = new PurchaseDetail();$Details->purchase_id=$id;}
                if($type == 'Sale'){$Details = new SaleDetail();$Details->sale_id=$id;}
                $Details->price = $value['price'];
                $Details->qty = $value['qty'];
                $Details->total = $value['sub_total'];
                break;

            case ($type == 'Supply' || $type == 'Cash'):

                if($type == 'Supply'){$Details = new SupplyDetail();$Details->supply_id=$id;}
                if($type == 'Cash'){$Details = new CashDetail();$Details->cash_id=$id;}
                break;        
                // table ReturnSaleDetail and ReturnPurchaseDetail must to changes into  SaleReturnDetail and PurchaseReturnDetail
        }

        $Details->store_product_id = $id_store_product;
        $Details->product_id = $value['product_id'];
        $Details->status_id = $value['status_id'];
        $Details->store_id = $value['store_id'];
        $Details->unit_id = $value['unit_id'];

        $Details->desc = $value['desc'];
        $Details->qty = $value['qty'];

        $Details->save();
    }
    function refresh_details($request,$value)
    {

        $type = $request['type'];
        $after_update = str_replace('Return', '', $type);

        $type_column = strtolower($after_update); 
       
        $condition = ['product_id'=>$request['product_id'][$value],
                        'status_id'=>$request['status_id'][$value],
                        'store_id'=>$request['store_id'][$value],
                        'unit_id'=>$request['unit_id'][$value],
                        $type_column.'_id'=>$request['id']];
        switch ($type) {

            case 'PurchaseReturn':
                PurchaseDetail::where($condition)->increment('qty_return', $request['qty'][$value]);
                // wherepurchase($request)->increment('qty_return', $request['qty'][$value]);
                break;
            case 'SaleReturn':
                SaleDetail::where($condition)->increment('qty_return', $request['qty'][$value]);
                break;
                    
            case 'SupplyReturn':
                SupplyDetail::where($condition)->increment('qty_return', $request['qty'][$value]);
                break; 
            
            case 'CashReturn':
                CashDetail::where($condition)->increment('qty_return', $request['qty'][$value]);
                break;        
                
    
        }
        

    }



    public function details(Request $request, $id)
    {
        // return response()->json(['details' => $request->all()]);
        $table = $request->post('table');
        $output = explode('_', $table);
        $column = $output[0];
   
        //-----------------------------------------------------------------------------------------------
        $details =  DB::table($table)->where($table.'.'. $column.'_id', $id)
            // ->where('store_products.quantity', '!=', 0)
            ->join('store_products', 'store_products.id', '=', $table.'.store_product_id')
            ->join('products', $table.'.product_id', '=', 'products.id')
            ->join('statuses', $table.'.status_id', '=', 'statuses.id')
            ->join('stores', $table.'.store_id', '=', 'stores.id')
            ->join('units', $table.'.unit_id', '=', 'units.id')
            ->select('products.*', 'products.text as product', 'units.name as unit', $table.'.*', 'statuses.name as status', 'stores.text as store', 'store_products.quantity as avilable_qty', 'store_products.desc', DB::raw($table.'.qty-' . $table.'.qty_return AS qty_remain'))
            ->get();

            $this->units($details);

        // foreach ($details as $key => $value) {

        //     $units = DB::table('product_units')
        //     ->join('units', 'units.id', '=', 'product_units.unit_id')
        //     ->join('products', 'products.id', '=', 'product_units.product_id')
        //     ->where('product_units.product_id', $value->product_id)
        //     ->select('units.*','products.rate','product_units.unit_type')
        //     ->get();

        // $value->units = $units;

      

        // }    


        return response()->json([$table => $details]);
    }


}
