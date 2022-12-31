<?php

require_once __DIR__.'/public/index.php';



public function payment(Request $request)
    {




        $temporale = $this->check_temporale('supply');

        if (count($temporale) != 0) {
            $supply = new Supply();

            $supply->supplier_id =  $request->post('supplier_id');
            $supply->supplier_name =  $request->post('supplier_name');

            $supply->quantity = $request->post('Total_quantity');
            $supply->date =  $request->post('date');

            $supply->save();

            foreach ($temporale as $value) {

                $stock_f = 0;
                $store_product_f = 0;

                $store_product_f = $this->refresh_store($value, 'increment');

                $id_store_product = $this->get($value);

                foreach ($id_store_product as $values) {


                    $id_store_product = $values['id'];
                }
                //----------------------------------------------------------------------------------------------------------------------------------------- 


                if ($store_product_f == 0) {


                    $id_store_product = $this->init_store($value);
                }

                $this->init_details($supply->id,$id_store_product,$value,'supply');

                $stock_f = $this->refresh_stock($supply->id, $value, 'supply', 'increment');

                if ($stock_f == 0) {

                    $this->init_stock($supply->id, $value, 'Supply', $request->post('date'));
                }
            }

            //----------------------------------------------------------------------------------------------------------------------------------------- 


            Temporale::where('type_process', 'supply')->delete();
            return response()->json(['message' => 'success']);
            //-----------------------------------------------------------------------------------------------------------------------------------------       
        }

        return response()->json(['message' => 'faild']);
    }
