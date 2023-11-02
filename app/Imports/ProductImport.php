<?php

namespace App\Imports;

use App\models\Product;
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

            'parent_id'    => $row[1],

            'text' => $row[2],

            'rank'     => $row[3],

            'purchase_price'    => $row[4],
            'status'    => $row[5],

            'rate'    => $row[6],

            'image'    => $row[7],

            'product_minimum'    => $row[8],





        ]);
    }
}
