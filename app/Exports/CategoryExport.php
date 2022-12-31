<?php

namespace App\Exports;

use App\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class CategoryExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Category::all();



        return DB::table('categories')
        ->join('group_categories','group_categories.id', '=', 'categories.group_id')

        ->select('categories.*')
        ->get();


    }
}
