<?php

namespace App\Services\Staff;

use App\Models\Account;
use App\Models\Payroll;
use App\Models\Staff;
use Illuminate\Support\Facades\Cache;
use App\Services\CoreStaffService;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Double;

class StaffService
{
    public $staff_id;
    public $hr_accounts;
    public $parent_id;
    public $rank;
    public $account_id;

    public function __construct(


        protected CoreStaffService $core,


    ) {
    }

    public function add_staff()
    {


        $staff = new Staff();
        $staff->name = $this->core->data['name'];
        $staff->personal_card = $this->core->data['card'];
        $staff->job_id = $this->core->data['job'];
        $staff->branch_id = $this->core->data['branch'];
        $staff->department_id = $this->core->data['department'];
        $staff->phone = $this->core->data['phone'];
        // $staff->work_type_id = $this->core->data['work');
        $staff->date = $this->core->data['date'];
        $staff->staff_status = $this->core->data['staff_status'];
        $staff->qualification_id = $this->core->data['qualification'];
        $staff->nationality_id = $this->core->data['nationality'];
        $staff->gender = $this->core->data['gender'];
        $staff->staff_type_id = $this->core->data['staff_type'];
        $staff->barth_date = $this->core->data['barth_date'];
        $staff->religion_id = $this->core->data['religion'];
        $staff->social_status = $this->core->data['social_status'];
        $staff->email = $this->core->data['email'];
        $staff->salary = $this->core->data['salary');
        $staff->save();
        $this->staff_id = $staff->id;

        Cache::forget('staff');
        Cache::forget('staff_eager_load_e');
    }



    public function add_account()
    {


        $this->get_hr_account();


        for ($i = 0; $i < 4; $i++) {

            $this->get_max_leave($i);
            $this->store_account($i);
            // $this->add_hr_account($i);
        }
    }


    public function store_account($value)
    {

        if ($this->core->data['type'] == $this->hr_accounts[$value]->code) {


            DB::table('accounts')->insert([
                [
                    'id' => $this->account_id,
                    'text' => $this->core->data['name'][$this->core->value],
                    'parent_id' => $this->hr_accounts[$value]->account_id,
                    'rank' => $this->rank + 1,
                    'status_account' => 'false'

                ]
            ]);
     
        }
    }
    public function add_hr_account($i)
    {

        DB::table('hr_staff_accounts')->insert(
            [
                'staff_id' =>  $this->staff_id,
                // 'account_id' => $this->account_id,
                'hr_account_id' => $this->hr_accounts[$i]->id,
            ]
        );

        Cache::forget('tree_accounts');
        Cache::forget('tree_accounts_node');
    }


    public function get_hr_account()
    {

        $this->hr_accounts = DB::table('hr_accounts')
            ->select('*')
            ->get();
    }

    public function get_max_leave($value)
    {

        if ($this->core->data['type'] == $this->hr_accounts[$value]->code) {



            $details = collect(Account::with('children')
                ->where('accounts.id', '=', $this->hr_accounts[$value]->account_id)
                ->select('accounts.*',)
                ->get())->toArray();



            $this->rank = $details[0]['rank'];
            if ($details[0]['children'] == null) {

                $this->account_id = ($details[0]['id'] * 10) + 1;
            } else {

                $this->account_id = Account::where('parent_id', $this->hr_accounts[$value]->account_id)
                    ->select('accounts.*')
                    ->max('id') + 1;
            }
        }
    }
    public function refresh_payroll()
    {


        $payroll = new Payroll();
        $payroll->staff_id = $this->staff_id;
        $payroll->net_salary = (float)$this->core->data['salary'];
        $payroll->save();
    }
}
