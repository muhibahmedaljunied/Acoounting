<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\models\Store;
use Carbon\Carbon;



class StoreExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Store::all();
    }

    public function map($row) : array {

        return [

            
            $row->id,

            $row->text,

            $row->parent_id,

            $row->account_id,

            $row->rank,

            $row->status,

            Carbon::parse($row->created_at)->toFormattedDateString(),

            Carbon::parse($row->updated_at)->toFormattedDateString()

        ] ;
 

    }

 

    public function headings() : array {


        return [

            'id',
            'text',
            'parent_id',
            'account_id',
            'rank',
            'status',
            'created_at',
            'updated_at'
 
 
         ] ;

        

    }

}
