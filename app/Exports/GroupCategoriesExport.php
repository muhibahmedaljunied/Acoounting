<?php

namespace App\Exports;

use App\GroupCategory;
use Maatwebsite\Excel\Concerns\FromCollection;


class GroupCategoriesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return GroupCategory::all();
    }
}
