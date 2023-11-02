<?php

namespace App\Imports;

use App\models\Store;
use Maatwebsite\Excel\Concerns\ToModel;

class StoreImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Store([

            'id'     => $row[0],

            'text'     => $row[1],

            'parent_id'     => $row[2],

            'rank'     => $row[3],

            'status'     => $row[4],

        ]);
    }
}
