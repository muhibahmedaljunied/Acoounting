<?php

namespace App\Exports;

use App\Models\HrAccount;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class HrSettingExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return HrAccount::all();
    }

    public function map($registration) : array {



        return [

            $registration->id,

            $registration->name,

            $registration->code,

            $registration->account_id,

            $registration->account_second_id,

            $registration->type,

            Carbon::parse($registration->created_at)->toFormattedDateString(),

            Carbon::parse($registration->updated_at)->toFormattedDateString()

        ] ;

 

 

    }

 

    public function headings() : array {


      

        return [

           'id',

           'name',

           'code',

           'account_id',

           'account_second_id',

           'type',
           
           'created_at',

           'updated_at'


        ] ;

    }
}
