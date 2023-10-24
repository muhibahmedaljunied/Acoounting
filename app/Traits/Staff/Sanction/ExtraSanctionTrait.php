<?php

namespace App\Traits\staff\Sanction;

use App\Models\Attendance;
use App\Models\StaffSanction;
use App\Models\Payroll;
use DB;

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

    
    public function update($temporale, $request)
    {

        $temporale_f = tap(ExtraSanction::whereExtraSanction($request))
            ->update(['sanction' => $request['sanction']])
            ->get('id');

        return $temporale_f;
    }


    public function get()
    {

        $extra = DB::table('extra_sanctions')
            ->join('extra_types', 'extra_types.id', '=', 'extra_sanctions.extra_type_id')
            ->join('parts', 'parts.id', '=', 'extra_sanctions.part_id')
            ->join('sanction_discounts', 'sanction_discounts.id', '=', 'extra_sanctions.sanction_discount_id')
            ->select('extra_sanctions.*', 'extra_sanctions.id as extra_sanction_id', 'parts.duration', 'extra_types.*', 'sanction_discounts.*')
            ->get();
        return $extra;
    }
    
    
  
}