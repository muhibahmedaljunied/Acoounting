<?php

namespace App\Traits\Purchase;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;
trait PurchaseTrait
{

    public function add_into_purchase_table()
    {


        $table_one = Purchase::create(
            [
                'supplier_id' => $this->core->data['supplier_id'],
                // 'supplier_name' => $this->core->data['supplier_name'],
                'grand_total' => $this->core->data['grand_total'],
                'sub_total' => $this->core->data['sub_total'],
                'discount' => $this->core->discount,
                'tax_amount' => $this->core->data['total_tax'],
                'date' => $this->core->data['date'],

            ]
        );

        $this->core->purchase_id = $table_one->id;
        // $this->core->purchase = $table_one;
        $this->core->stockable = $table_one;
        $this->core->paymentable = $table_one;


        // return $table_one;
    }

    public function refresh_purchase_table()
    {


        DB::table('purchases')
            ->where(['id' => $this->core->purchase_id])
            ->update(['daily_id' => $this->core->daily_id]);
    }

    



}
