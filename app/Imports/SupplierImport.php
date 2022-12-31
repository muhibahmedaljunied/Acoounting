<?php

namespace App\Imports;

use App\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;

class SupplierImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Supplier([
            
            'id'     => $row[0],
            'name'    => $row[1],
            'last_name' => $row[2],
            'code'     => $row[3],
            'company'    => $row[4],
            'email'    => $row[5],
            'phone'    => $row[6],
            'address'    => $row[7],
            'status' => $row[8],
     


        ]);
    }
}
