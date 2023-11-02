<?php

namespace App\Exports;

use App\Models\AdministrativeStructure;
use Maatwebsite\Excel\Concerns\FromCollection;

class AdministrativeStructureExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AdministrativeStructure::all();
    }
}
