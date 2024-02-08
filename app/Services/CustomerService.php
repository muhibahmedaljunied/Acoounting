<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use App\Models\Customer;
class CustomerService
{
    public $id;
    public $parent;
    public $child;
    public $request;
  
    public function get_parent(){

        $this->parent =  DB::table('accounts')
                ->where('accounts.id', $this->request->post('account'))
                ->select(
                    'accounts.*',

                )
                ->first();
    }
    public function get_child(){
        
        $childs = Account::where('parent_id', $this->parent->id)->select('accounts.*')->max('id');
        $this->id = ($childs == null) ? $this->request->post('account') * 10 + 1 : $childs + 1;
    }

    public function add_account(){
        

        $account = new Account();
        $account->id = $this->id;
        $account->text = 'المورد' . ' ' . $this->request->post('name') . ' ' . $this->request->post('last_name');
        $account->parent_id = $this->parent->id;
        $account->rank = $this->parent->rank + 1;
        $account->status_account = false;
        $account->save();
        
    }

    public function add_supplier(){
        

        $user = new Customer();
        $user->name = $this->request->post('name');
        $user->last_name = $this->request->post('last_name');
        $user->email = $this->request->post('email');
        $user->phone = $this->request->post('phone');
        $user->account_id = $this->id;
        $user->address = $this->request->post('address');
        $user->save();
    }


    
}
