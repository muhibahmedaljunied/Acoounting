<?php

namespace App\Traits\staff\Sanction;
use App\Models\AbsenceSanction;
use DB;

trait AbsenceSanctionTrait
{


    public function add($request, $value)
    {

        $temporale = new AbsenceSanction();
        $temporale->absence_type_id = $request['extra'][$value];
        $temporale->part_id = $request['absence_part'][$value];
        $temporale->iteration = $request['iteration'][$value];
        $temporale->sanction_discount_id = $request['discount_type'][$value];
        $temporale->sanction = $request['sanction'][$value];
        $temporale->save();
        return $temporale->id;

    }

    
    public function update($temporale, $request)
    {

        $temporale_f = tap(AbsenceSanction::whereAbsenceSanction($request))
            ->update(['sanction' => $request['sanction']])
            ->get('id');

        return $temporale_f;
    }

    
    public function get()
    {

        $extra = DB::table('absence_sanctions')
            ->join('absence_types', 'absence_types.id', '=', 'absence_sanctions.absence_type_id')
            ->join('parts', 'parts.id', '=', 'absence_sanctions.part_id')
            ->join('sanction_discounts', 'sanction_discounts.id', '=', 'absence_sanctions.sanction_discount_id')
            ->select('absence_sanctions.*', 'absence_sanctions.id as absence_sanction_id', 'parts.duration', 'absence_types.*', 'sanction_discounts.*')
            ->get();
        return $extra;
    

}
