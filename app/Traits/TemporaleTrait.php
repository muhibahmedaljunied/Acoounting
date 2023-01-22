<?php

namespace App\Traits;

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



        return $temporale;
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
            ->select('products.text as product', 'temporales.qty as tem_qty', 'temporales.desc', 'temporales.*', 'stores.text as store', 'statuses.name as status')
            ->get();

        return $temporale;
    }


    function add_temporale($request, $value, $type, $id = null, $id_store_product = null)
    {


        if ($type == 'transfer') {
            $temporale = new TransferDetail();
        } else {

            $temporale = new Temporale();
        }
        // $temporale->product_id =  $request['product'][$value];
        // $temporale->product_name =$request['product_name'][$value];
        // $temporale->qty = $request['qty'][$value];

        switch ($type) {

            // case 'transfer':
            //     $temporale->transfer_id =  $id;

            //     $temporale->product_id =  $request['product_id'][$value];
            //     $temporale->store_product_id = $id_store_product;

            //     // $temporale->product_name =$request['product_name'][$value];
            //     $temporale->qty = $request['qty'][$value];
            //     $temporale->store_id =  $request['store_id'][$value];

            //     $temporale->status_id =  $request['status_id'][$value];
            //     $temporale->desc =  $request['desc'][$value];
            //     $temporale->into_store =  $request['intostore'][$value];


            //     break;
            case ($type == 'expence'):
                $temporale->expence_id =  $request['expence_type'][$value];
                $temporale->qty = $request['qty'][$value];
   

                break;

            case ($type == 'supply' || $type == 'cash'):
                $temporale->product_id =  $request['product'][$value];
                // $temporale->product_name =$request['product_name'][$value];
                $temporale->qty = $request['qty'][$value];
                $temporale->store_id =  $request['store'][$value];

                $temporale->status_id =  $request['status'][$value];
                $temporale->desc =  $request['desc'][$value];

                break;
            case 'purchase':
                $temporale->product_id =  $request['product'][$value];
                // $temporale->product_name =$request['product_name'][$value];
                $temporale->qty = $request['qty'][$value];
                $temporale->store_id =  $request['store'][$value];

                $sub_total = $request['qty'][$value] * $request['price'][$value];
                $total = $request['qty'][$value] * $request['price'][$value] + $request['tax'][$value];
                $temporale->tax =  $request['tax'][$value];
                $temporale->price =  $request['price'][$value];
                $temporale->sub_total = $sub_total;
                $temporale->total = $total;
                $temporale->status_id =  $request['status'][$value];
                $temporale->desc =  $request['desc'][$value];
                break;
            case 'sale':
                $temporale->product_id =  $request['product'][$value];
                // $temporale->product_name =$request['product_name'][$value];
                $temporale->qty = $request['qty'][$value];
                $temporale->store_id =  $request['store'][$value];

                $sub_total = $request['qty'][$value] * $request['price'][$value];
                $total = $request['qty'][$value] * $request['price'][$value] + $request['tax'][$value];
                $temporale->tax =  $request['tax'][$value];
                $temporale->price =  $request['price'][$value];
                $temporale->sub_total = $sub_total;
                $temporale->total = $total;
                $temporale->status_id =  $request['status'][$value];
                $temporale->desc =  $request['desc'][$value];
                break;
        }



        if ($type == 'transfer') {
            $temporale->save();
        } else {
            $temporale->type_process = $type;
        }
        $temporale->save();
    }
}
