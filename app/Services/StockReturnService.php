<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\Repository\StockReturnInventury\StockReturnRepository;
use App\Repository\StoreReturnInventury\StoreReturnRepository;
use App\RepositoryInterface\WarehouseRepositoryInterface;
use App\Services\DailyStockService;

 class  StockReturnService
{




    public function __construct(

        public Request $request,
        public CoreService $core,
        public WarehouseRepositoryInterface $warehouse,
        public DetailRefreshRepositoryInterface $refresh,
        public DetailRepositoryInterface $detail,
        public StoreReturnRepository $store,
        public StockReturnRepository $stock,
        public UnitService $unit,
        public DailyStockService $daily,
    ) {


        $this->core->setData($request->all());
    }

    public function handle(
        
        
    ) {


        // dd($this->core->data);
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
            $this->refresh->refresh_details();
        
            $this->stock->stock();
        
   
        }
        // dd(1);

        $this->daily->daily()->exicute('debit')->exicute('credit');

        $this->warehouse->refresh(); //this update purchase_return table by daily_id
    }
}
