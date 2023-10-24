<?php

namespace App\Services;
use DB;

class MuhibService 
{
  

    public function store()
    {


      DB::table('products')
      ->select('products.*',)
      ->get();

      dd('i am in facad');
    }

   
}
