<?php

namespace App\Services\Staff;
use App\Repository\StaffSaction\StaffAbsenceSanctionRepository;
use App\Traits\staff\Sanction\AbsenceSanctionTrait;
use App\Services\CoreStaffService;
use Illuminate\Support\Facades\DB;
class AbsenceService
{

    use AbsenceSanctionTrait;

    public function __construct(

        protected StaffAbsenceSanctionRepository $details,
        protected CoreStaffService $core,

    ) {
    }


    public function create()
    {
        $this->get();  //this get absence_sanctions
        $absence = DB::table('absences')->get(); //this calc from absence_table
        for ($i = 0; $i < count($this->core->data_sanction); $i++) {
            
            //this check if type of absence equal type of sanction
            if ($this->core->data['absence_type'][$this->core->value] == $this->core->data_sanction[$i]->absence_type_id) {

                $this->handle($i, $absence);
             }
        }


        return $this;
    }

    public function handle($i,$absence)
    {

        
        $this->show($this->core->data_sanction[$i]->sanction_id);  
        if ($this->core->data_sanction[$i]->iteration == 6) { //هذا في حاله كان الخيار اي مره
           

            $this->details->sanction();

        }
        if (count($absence) == $this->core->data_sanction[$i]->iteration) { //هذا في حاله كان الخيار عدد المرات

            $this->details->sanction();

        }
    }


  
}
