<?php

namespace App\Services;
use App\RepositoryInterface\DailyRepositoryInterface;
// use App\Traits\DailyTrait;
use Illuminate\Http\Request;
use App\Services\CoreService;
class DailyService extends CoreService
{
   // use DailyTrait;
   // public $message;
   // public $status_request = 'faild';
   // public $core;
   // public function __construct(Request $request,protected DailyRepositoryInterface $daily)
   // {

   //    $this->core = app(CoreService::class);
      
   // }

   // public function daily()
   // {
   //    for ($i = 0; $i < 2; $i++) {

   //       $this->daily->data_store['count'][$i] = $i;
   //       $this->daily->data_store['account_id'][$i] = $this->core->data['store_account'];
   //       $this->daily->data_store['debit'][$i] = $this->core->data['remaining'];
   //       $this->daily->data_store['credit'][$i] = $this->core->data['paid'];

   //       // if ($i == 1) {

   //       //    $this->daily->payment();
   //       // }
   //    }

   //    dd($this->daily->data_store);
   //    $this->create();
   //    $this->store();
   // }
 

 

   public function check_account()
   {

      $this->message = array(
         'message' => '',
      );
      if (!$this->core->data['store_account']) {

         $this->message['message'] = 'المخزن غير مرتيط بحساب';
         return 0;
      }

      if (!$this->core->data['treasury_account']) {

         $this->message['message'] = 'الصندوق غير مرتيط بحساب';
         return 0;
      }

      if (!$this->core->data['supplier_account']) {

         $this->message['message'] = 'المورد غير مرتيط بحساب';
         return 0;
      }
      $this->status_request = 'success';
      return 1;
   }
}
