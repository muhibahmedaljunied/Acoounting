<?php

namespace App\Services;

use App\RepositoryInterface\DailyRepositoryInterface;
use App\Services\CoreService;
use App\Traits\DailyTrait;
class DailyService1 extends CoreService
{
   use DailyTrait;
   public $message;
   public $status_request = 'faild';
   public $core;
   public function __construct(
      protected DailyRepositoryInterface $daily,
   ) {

      // $this->core = app(CoreService::class);
   }




   public function daily()
   {


      $this->daily->handle();
      $this->db_create();
      $this->db_store();
   }

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
