<?php

namespace App\Exports;

use App\Models\AdministrativeStructure;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdministrativeStructureExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AdministrativeStructure::all();
    }

    public function map($registration) : array {



        return [

            $registration->id,

            $registration->text,

            // $registration->account_name_en,

            $registration->parent_id,

            $registration->rank,

            // $registration->account_type,

            // $registration->currency,

            $registration->type_branch,

            // $registration->status_account,
            $registration->status,

            Carbon::parse($registration->created_at)->toFormattedDateString(),

            Carbon::parse($registration->updated_at)->toFormattedDateString()

        ] ;

 

 

    }

 

    public function headings() : array {


      

        return [

           'id',

           'text',

        //    'account_name_en',

           'parent_id',

           'rank',

        //    'account_type',

        //    'currency',

           'type_branch',

           'status',

           'created_at',

           'updated_at'


        ] ;

    }
}
