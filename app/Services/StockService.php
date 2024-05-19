<?php

namespace App\Services;

use App\Models\Daily;
use App\Models\DailyDetail;
use App\Models\GroupAccount;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Repository\StockInventury\StockRepository;
use App\Repository\StoreInventury\StoreRepository;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\Services\DailyStockService;
use App\Services\PaymentService;
 class  StockService
{




    public function __construct(

        public Request $request,
        public CoreService $core,
        public WarehouseRepositoryInterface $warehouse,
        public DetailRefreshRepositoryInterface $refresh,
        public DetailRepositoryInterface $detail,
        public StoreRepository $store,
        public StockRepository $stock,
        public UnitService $unit,
        public DailyStockService $daily,
        public PaymentService $payment,
    ) {


        $this->core->setData($request->all());
        $this->core->setDiscount($request['discount'] * $request['grand_total'] / 100);
    }

    public function handle(
        
        
    ) {

        $this->warehouse->add();

     
        foreach ($this->core->data['count'] as $value) {


            // -------------------------------------------------------------------------------------

            // $result = $check->check_return($request['old'][$value]);

            // if ($result['status'] == 0) {
            //     return response(['message' => $result['text'], 'status' => $result['status']]);
            // }

            // -------------------------------------------------------------------------------------

            $this->core->setValue($value);
            $this->unit->unit_and_qty(); // this make decode for unit and convert qty into miqro
            $this->store->store();
            $this->detail->init_details();
            $this->stock->stock();
 
        }

        $this->payment->pay();

        $this->daily->daily()->exicute('debit')->exicute('credit');
        // dd(DailyDetail::all());
        $this->warehouse->refresh(); //this update purchase_return table by daily_id
    }
}
