<?php

namespace App\Services;

use App\Repository\StockInventury\StockRepository;
use Illuminate\Http\Request;
use App\RepositoryInterface\DetailRefreshRepositoryInterface;
use App\RepositoryInterface\DetailRepositoryInterface;
use App\RepositoryInterface\StoreRepositoryInterface;
use App\RepositoryInterface\UnitRepositoryInterface;
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
        public StoreRepositoryInterface $store,
        public StockRepository $stock,
        public UnitRepositoryInterface $unit,
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
            $this->unit->handle_unit();
            $this->store->store();
            $this->detail->details();
            $this->stock->stock();
        
   
        }
        // dd(1);

        $this->daily->daily()->exicute('debit')->exicute('credit');
        $this->warehouse->refresh(); //this update purchase_return table by daily_id
    }
}
