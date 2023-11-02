<?php

namespace App\Imports;

use App\Models\AdministrativeStructure;
use Maatwebsite\Excel\Concerns\ToModel;

class AdministrativeStructureImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AdministrativeStructure([
         
        ]);
    }
}
