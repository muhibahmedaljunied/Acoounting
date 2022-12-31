<?php

namespace App\Imports;

use App\GroupCategory;
use Maatwebsite\Excel\Concerns\ToModel;

class GroupCategoryImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new GroupCategory([
            
            'id'     => $row[0],
            'name'     => $row[1],

     

        ]);
    }
}
