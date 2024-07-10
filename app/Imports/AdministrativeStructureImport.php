<?php

namespace App\Imports;

use App\Models\AdministrativeStructure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdministrativeStructureImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AdministrativeStructure([
         
            'id'=>$row['id'],
            'text'     => $row['text'],
            // 'account_name_en'     => $row['account_name_en'],
            'parent_id'    => $row['parent_id'],
            'rank'    => $row['rank'],
            // 'account_type'    => $row['account_type'],
            // 'currency'    => $row['currency'],
            'type_branch'    => $row['type_branch'],
            'status'    => $row['status'],
            'created_at'    => $row['created_at'],
            'updated_at'    => $row['updated_at'],

        ]);
    }
}
