<?php
namespace App\Repository\HR;
use App\RepositoryInterface\HRRepositoryInterface;
use App\Services\CoreStaffService;
use App\Models\Vacation;


use DB;

class VacationRepository implements HRRepositoryInterface
{
    // public $core;
    public function __construct(public CoreStaffService $core)
    {

        // $this->core = app(CoreStaffService::class);
        
    }
    function Sum($data)
    {


        foreach ($data as $sub) {

            $sub->sum_vacation = 0;
            foreach ($sub->vacation as $key => $value) {

                $sub->sum_vacation += $value->total_days;
            }
        }
    }
    function add(...$list_data)
    {
    
        $temporale = new Vacation();
        $temporale->staff_id = $this->core->data['staff'][$this->core->value];
        $temporale->vacation_type_id = $this->core->data['leave_type'][$this->core->value];
        $temporale->start_date = $this->core->data['start_date'][$this->core->value];
        $temporale->end_date = $this->core->data['end_date'][$this->core->value];
        $temporale->total_days = $this->core->data['days'][$this->core->value];

        $temporale->save();
        $this->core->id = $temporale->id;
    }

    public function update()
    {
    
        $temporale_f = tap(Vacation::whereLeave($this->core->data))
        ->update(['total_days' => $this->core->data['days'][$this->core->value]])
        ->get('id');

        return $temporale_f;
    }
}
