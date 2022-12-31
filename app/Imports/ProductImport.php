<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            

            'id'     => $row[0],
            'name'    => $row[1],
            'category_id' => $row[2],
            'image'     => $row[3],
            'notes'    => $row[4],
            'status'    => $row[5],




        ]);
    }
}
