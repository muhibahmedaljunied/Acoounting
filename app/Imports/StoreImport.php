<?php

namespace App\Imports;

use App\models\Store;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StoreImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Store([

            'id' => $row['id'],
            'text' => $row['text'],
            'parent_id' => $row['parent_id'],
            'account_id' =>$row['account_id'],
            'rank' => $row['rank'],
            'status' => $row['status'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],

        ]);
    }
}
