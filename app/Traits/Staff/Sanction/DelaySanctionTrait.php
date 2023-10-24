<?php

namespace App\Traits\staff\Sanction;
use DB;

trait DelaySanctionTrait
{


    public function add($request, $value)
    {

        $temporale = new DelaySanction();
        $temporale->delay_type_id = $request['delay'][$value];
        $temporale->part_id = $request['delay_part'][$value];
        $temporale->iteration = $request['iteration'][$value];
        $temporale->sanction_discount_id = $request['discount_type'][$value];
        $temporale->discount = $request['discount'][$value];
        $temporale->sanction = $request['sanction'][$value];
        $temporale->save();
        return $temporale->id;
    }

    public function update($request)
    {

        $temporale_f = tap(DelaySanction::whereDelaySanction($request))
            ->update(['sanction' => $request['sanction']])
            ->get('id');


        return $temporale_f;
    }


    
    public function get()
    {

        $delay = DB::table('delay_sanctions')
            ->join('delay_types', 'delay_types.id', '=', 'delay_sanctions.delay_type_id')
            ->join('parts', 'parts.id', '=', 'delay_sanctions.part_id')
            ->join('sanction_discounts', 'sanction_discounts.id', '=', 'delay_sanctions.sanction_discount_id')
            ->select('delay_sanctions.*', 'delay_sanctions.id as delay_sanction_id', 'parts.duration', 'delay_types.*', 'sanction_discounts.*')
            ->get();
        return $delay;
    }
    

  
}