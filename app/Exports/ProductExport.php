<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\models\Product;
use Carbon\Carbon;



class ProductExport implements FromCollection,WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::all();
    }

    public function map($registration) : array {

        return [

        
            $registration->id,

            $registration->parent_id,

            $registration->text,

            $registration->rank,

            $registration->purchase_price,

            $registration->status,

            $registration->rate,

            $registration->product_minimum,

            $registration->image,


            Carbon::parse($registration->created_at)->toFormattedDateString(),

            Carbon::parse($registration->updated_at)->toFormattedDateString()

        ] ;
 

    }

 

    public function headings() : array {


        return [

            'id',
 
            'parent_id',
 
            'text',
 
            'rank',
 
            'purchase_price',

            'status',

            'rate',

            'product_minimum',

            'image',


            'created_at',
 
            'updated_at'
 
 
         ] ;

        

    }

}
