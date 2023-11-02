<?php

namespace App\Exports;
use App\Models\PeriodTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class PeriodTimeExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        
        return PeriodTime::all();
    }
    

    public function map($registration) : array {

        return [

            
            $registration->id,

            $registration->period->id,

            $registration->from_time,

            $registration->into_time,

            $registration->duration,

            Carbon::parse($registration->created_at)->toFormattedDateString(),

            Carbon::parse($registration->updated_at)->toFormattedDateString()

        ] ;
 

    }

 

    public function headings() : array {


        return [

            'id',
 
            'period_time',
 
            'from_time',
 
            'into_time',
 
            'duration',
 
            'created_at',
 
            'updated_at'
 
 
         ] ;

        

    }

}
