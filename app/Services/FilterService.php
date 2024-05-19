<?php

namespace App\Services;

use App\Models\Store;

class FilterService
{
    public $array_where = [];
    public $count = 0;
    public  $store_id;
    public $array_data;
    public $root;
    public $link;


    public $data = [
        [
            "id" => 0,
        ]

    ];






    public function foreach_root($link)
    {

        foreach ($link as $value) {

            $this->filter($value);
        }


        
    }


    function queryfilter()
    {


        // dd($this->store_id);
        $product = Store::where(function ($query) {
            return $query->where('parent_id', '=', $this->store_id)
                ->orWhere('id', '=', $this->store_id)->where('status', '=', 'false');
        })
            ->with('children')
            ->get();

            $this->root = collect($product)->toArray();
            $this->foreach_root($this->root);



        return $this;
    }

 


    function filter($value)
    {


      
        if ($value['children'] == null) {

            $this->get_details($value);

        } else {   


            $this->refresh_final_array($value['id']);
            $this->foreach_root($value['children']);
        }
    }

    function get_details($value)
    {


        if ($value['status'] == 'false') {


            if (empty($this->array_where)) {


                $store = Collect(Store::where(function ($query) use ($value) {
                    return $query->where('id', '=', $value['id']);
                })->select('id')
                    ->get())->toArray();

             $this->refresh_final_array($store[0]['id']);
            }
        }
    }

    function refresh_final_array($value){

        $this->data[$this->count] = $value;
        $this->count = $this->count + 1;

    }
}
