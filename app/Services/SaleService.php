<?php

namespace App\Services;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Services\InventureService;
use App\Repository\Stock\SaleRepository;
use App\Services\CoreService;
use App\Traits\DailyTrait;
use App\Models\PaymentSale;
class SaleService 
{
    public $request;
    public $sale_id = 0;
    public $temporale = 0;
    public $discount;

    use DailyTrait;
    public function __construct(
    
        protected InventureService $inventury,
        protected SaleRepository $daily,
        protected CoreService $core,
        protected DetailRepositoryInterface $details,


    ) {
        // $this->core = app(CoreService::class);
    }

    // public function Stock()
    // {

    //     $this->stock->init_stock();
    // }
    // public function store()
    // {

    //     $this->store->get_store()->refresh_store(); // this make refresh for store_products



    // }

   
    // public function add_into_purchase_table()
    // {

   
    //     $this->stockRepo->add();

    // }

    // public function add_into_purchase_details_table()
    // {

   
    //     $this->details->init_details(); // this make initial for details table

    // }

    // public function unit_and_qty()
    // {

    //     // this make decode for unit and convert qty into miqro
    //     $this->stockRepo->decode_unit();
    //     $this->stockRepo->convert_qty();


    // }


    // public function daily()
    // {
       
    //     $this->daily->handle();
    //     $this->db_create();
    //     $this->db_store();
    // }


    public function pay(){


        $payment_status = 'pendding';
        $payment_info = $this->core->data['type'];
        if ($this->core->data['paid'] == 0) { $payment_status = 'pendding';}
        if ($this->core->data['paid'] != 0 && $this->core->data['remaining'] != 0) {$payment_status = 'Partially';}
        ($this->core->data['remaining'] == 1) ? $payment_info = $this->core->data['type'] : $payment_info = 'credit' ;$payment_status = 'paiding';
        $payment = new PaymentSale();
        $payment->sale_id = $this->core->sale_id;
        $payment->payment_info = $payment_info;
        $payment->payment_status = $payment_status;
        $payment->paid = $this->core->data['paid'];
        $payment->remaining = $this->core->data['remaining'];
        $payment->save();
        // return $payment->id;
        return $this;

    }

   
}
