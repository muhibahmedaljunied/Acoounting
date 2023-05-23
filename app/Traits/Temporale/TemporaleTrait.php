<?php

namespace App\Traits\Temporale;

use App\Models\Temporale;
use App\Models\TransferDetail;
use DB;

trait TemporaleTrait
{

    function check_temporale($type)
    {

        if ($type == 'transfer') {

            $temporale = DB::table('transfer_details')
                ->select('transfer_details.*')
                ->get();
        } else {

            $temporale = Temporale::where('temporales.type_process', $type)
                ->select('temporales.*')
                ->get();
        }


        return $temporale->toarray();
    }



    function all_temporale()
    {

        $temporale = DB::table('temporales')
            ->join('products', 'products.id', '=', 'temporales.product_id')
            ->join('stores', 'temporales.store_id', '=', 'stores.id')
            ->join('statuses', 'temporales.status_id', '=', 'statuses.id')
            ->select('products.*', 'temporales.qty as tem_qty', 'temporales.*', 'stores.*', 'statuses.*')
            ->get();

        return $temporale;
    }


    function one_temporale($type)
    {

        $temporale = Temporale::where('temporales.type_process', $type)
            ->join('stores', 'temporales.store_id', '=', 'stores.id')
            ->join('statuses', 'temporales.status_id', '=', 'statuses.id')
            ->join('products', 'products.id', '=', 'temporales.product_id')
            ->join('units', 'units.id', '=', 'temporales.unit_id')
            ->select('products.text as product', 'temporales.qty as tem_qty', 'temporales.desc', 'temporales.*', 'stores.text as store', 'statuses.name as status','units.name as unit')
            ->get();

        return $temporale;
    }


    // function add_temporale($request, $value, $type, $id = null, $id_store_product = null)
    function add_temporale(...$list_data)
    {


        $request = $list_data['request'];
        $value = $list_data['value'];
        $type = $list_data['type'];
        // $id = $list_data['id'];
        // $id_store_product = $list_data['id_store_product'];

        $array_unit_after_decode =$request['unit'][$value];
        // return $array_unit_after_decode[0];
        
        // if ($type == 'Transfer') {
        //     $temporale = new TransferDetail();
        // } else {

            $temporale = new Temporale();
        // }
     
        switch ($type) {

            case ($type == 'Expence'):
                $temporale->expence_id =  $request['expence_type'][$value];
                $temporale->qty = $request['qty'][$value];

                break;

            case ($type == 'Supply'):
                $array_unit_after_decode =json_decode($request['unit'][$value]);
                $micro_unit_qty = $this->set_unit($request,$value,$array_unit_after_decode);
                $temporale->product_id =  $request['product'][$value];
                // $temporale->qty = $request['qty'][$value];
                $temporale->store_id =  $request['store'][$value];
                $temporale->status_id =  $request['status'][$value];
                $temporale->unit_id =  $array_unit_after_decode[0];
                $temporale->qty = $micro_unit_qty;
                $temporale->desc =  $request['desc'][$value];

                break;


            case ($type == 'Cash'):
                $micro_unit_qty = $this->set_unit($request,$value,$array_unit_after_decode);
                $temporale->product_id =  $request['product'][$value];
                // $temporale->qty = $request['qty'][$value];
                $temporale->store_id =  $request['store'][$value];
                $temporale->status_id =  $request['status'][$value];
                $temporale->unit_id =  $array_unit_after_decode[0];
                $temporale->qty = $micro_unit_qty;
                $temporale->desc =  $request['desc'][$value];

                break;    
            case 'Purchase':

           
                $array_unit_after_decode =json_decode($request['unit'][$value]);
                $micro_unit_qty = $this->set_unit($request,$value,$array_unit_after_decode);
                $temporale->product_id =  $request['product'][$value];
                // $temporale->qty = $request['qty'][$value];
                $temporale->store_id =  $request['store'][$value];
                $temporale->tax =  $request['tax'][$value];
                $temporale->price =  $request['price'][$value];
                $temporale->sub_total = $request['total'][$value];
                $temporale->total = $request['total'][$value] + $request['tax'][$value];
                $temporale->status_id =  $request['status'][$value];
                $temporale->unit_id =  $array_unit_after_decode[0];
                $temporale->qty = $micro_unit_qty;
                $temporale->desc =  $request['desc'][$value];
                break;
            case 'Sale':

                $micro_unit_qty = $this->set_unit($request,$value,$array_unit_after_decode);
                $temporale->product_id =  $request['product'][$value];
                // $temporale->qty = $request['qty'][$value];
                $temporale->store_id =  $request['store'][$value];
                $temporale->tax =  $request['tax'][$value];
                $temporale->price =  $request['price'][$value];
                $temporale->sub_total = $request['total'][$value];
                $temporale->total = $request['total'][$value] + $request['tax'][$value];
                $temporale->status_id =  $request['status'][$value];
                $temporale->unit_id =  $array_unit_after_decode[0];
                $temporale->qty = $micro_unit_qty;
                $temporale->desc =  $request['desc'][$value];
                break;
        }



        // if ($type == 'Transfer') {
        //     $temporale->save();
        // } else {
        //     $temporale->type_process = $type;
        // }
        $temporale->type_process = $type;
        $temporale->save();
    }


    function set_unit($request,$value,$array_unit_after_decode){

        if($array_unit_after_decode[2] == 0){  //this means unit_type

            $micro_unit_qty = $request['qty'][$value];
        }else{

            $micro_unit_qty = $request['qty'][$value]*$array_unit_after_decode[1]; 
        }

        return $micro_unit_qty;

    }
}
