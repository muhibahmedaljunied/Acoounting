<?php

namespace App\Traits\staff\Sanction;

use App\Models\ExtraSanction;
use Illuminate\Support\Facades\DB;

trait ExtraSanctionTrait
{


    public function add($request, $value)
    {

        $temporale = new ExtraSanction();
        $temporale->extra_type_id = $request['extra'][$value];
        $temporale->part_id = $request['extra_part'][$value];
        $temporale->iteration = $request['iteration'][$value];
        $temporale->sanction_discount_id = $request['discount_type'][$value];
        $temporale->sanction = $request['sanction'][$value];
        $temporale->save();
        return $temporale->id;
    }


    public function update($request)
    {

        return tap(ExtraSanction::whereExtraSanction($request))
            ->update(['sanction' => $request['sanction']])
            ->get('id');

        
    }


    public function get()
    {

        $this->core->data_sanction =  DB::table('extra_sanctions')
            ->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id')
            ->join('parts', 'parts.id', '=', 'extra_sanctions.part_id')
            ->join('sanction_discounts', 'sanction_discounts.id', '=', 'extra_sanctions.sanction_discount_id')
            ->select(
                'extra_sanctions.*',
                'extra_sanctions.id as sanction_id',
                'extra_sanctions.id as extra_sanction_id',
                'parts.duration',
                'extra_types.*',
                'sanction_discounts.*'
            )
            ->get();
    }

    
    public function show($id)
    {


        $this->core->specific_sanction = ExtraSanction::find($id);
      
    }
}
