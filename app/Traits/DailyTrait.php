<?php
namespace App\Traits;
use App\Models\Daily;
use App\Models\DailyDetail;
use DB;
trait DailyTrait{


    public function db_create()
    {
 
       $daily = new Daily();
       $daily->daily_date = $this->core->data['date'];
       $daily->description = $this->core->data['description'];
       // $daily->total = $this->data['total'];
       $daily->save();
      //  dd($daily->id);

       $this->id = $daily->id;
       return $this;
      
    }
 
    public function db_store()
    {
    

       foreach ($this->daily->data_store['count'] as $i) {
 
          $dailydetail = new DailyDetail();
          $dailydetail->daily_id = $this->id;
          $dailydetail->account_id = $this->daily->data_store['account_id'][$i];
          $dailydetail->debit =  $this->daily->data_store['debit'][$i];
          $dailydetail->credit =  $this->daily->data_store['credit'][$i];
          $dailydetail->save();
       }
    }

   //  public function get_account_sale_cost(){


   //    $detail = DB::table('purchase_return_details')
   //    ->select('purchase_return_details.*')
   //    ->get();

   //  }

   //  public function get_account_sale(){
        
   //    $detail = DB::table('purchase_return_details')
   //    ->select('purchase_return_details.*')
   //    ->get();

   //  }
    

}



