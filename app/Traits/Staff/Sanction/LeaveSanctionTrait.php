<?php

namespace App\Traits\staff\Sanction;

use App\Models\LeaveSanction;
use Illuminate\Support\Facades\DB;

trait LeaveSanctionTrait
{


    public function add($request, $value)
    {
        $temporale = new LeaveSanction();
        $temporale->leave_type_id = $request['leave'][$value];
        $temporale->part_id = $request['leave_part'][$value];
        $temporale->iteration = $request['iteration'][$value];
        $temporale->sanction_discount_id = $request['discount_type'][$value];
        $temporale->discount = $request['discount'][$value];
        $temporale->sanction = $request['sanction'][$value];

        $temporale->save();
        return $temporale->id;
    }

    public function update($temporale, $request)
    {

        $temporale_f = tap(LeaveSanction::whereLeaveSanction($request))
            ->update(['sanction' => $request['sanction']])
            ->get('id');
        return $temporale_f;
    }

    public function get()
    {

        $this->attendance_core->data_sanction =  DB::table('leave_sanctions')
            ->join('leave_types', 'leave_types.id', '=', 'leave_sanctions.leave_type_id')
            ->join('parts', 'parts.id', '=', 'leave_sanctions.part_id')
            ->join('sanction_discounts', 'sanction_discounts.id', '=', 'leave_sanctions.sanction_discount_id')
            ->select(
                'leave_sanctions.*',
                'leave_sanctions.id as sanction_id',
                'leave_sanctions.id as leave_sanction_id',
                'parts.duration',
                'leave_types.*',
                'sanction_discounts.*'
            )
            ->get();
    }

    public function show($id)
    {


        $this->attendance_core->specific_sanction = LeaveSanction::find($id);
      
    }

}
