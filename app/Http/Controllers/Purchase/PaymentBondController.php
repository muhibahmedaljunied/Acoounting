<?php

namespace App\Http\Controllers\Purchase;
use App\Repository\Note\PaymentBondRepository;
use App\Services\UnitService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\Invoice\InvoiceTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\status;
use App\Services\CoreService;
use App\Services\DailyService;


class PaymentBondController extends Controller
{
    use InvoiceTrait,
        GeneralTrait;


    public function __construct(

        protected CoreService $core,
        protected PaymentService $payment,
        protected UnitService $unit,
        Request $request,

    ) {


        $this->core->setData($request->all());
    }

    


    public function payment_bond(Request $request)
    {

        $data = DB::table('purchases')
            ->where('purchases.id', $request->id)
            ->join('payment_purchases', 'payment_purchases.purchase_id', '=', 'purchases.id')
            ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
            ->join('accounts', 'accounts.id', '=', 'suppliers.account_id')

            ->select(
                'purchases.*',
                'suppliers.id',
                'suppliers.account_id as supplier_account_id',
                'suppliers.name',
                'payment_purchases.*',
                'accounts.id as account_id',
                'accounts.text'
            )
            ->get();
        return response()->json(['list_data' => $data]);
    }

    public function store_PaymentBond(
        DailyService $dailyService,
        PaymentBondRepository $note

    ) {

        // dd($this->core->data);


        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            $dailyService->daily()->debit()->credit();
            $note->finish();
            $this->payment->update();

    
            DB::commit(); // Tell Laravel this transacion's all good and it can persist to DB

            return response([
                'message' => "daily created successfully",
                'status' => "success"
            ], 200);
        } catch (\Exception $exp) {

            DB::rollBack(); // Tell Laravel, "It's not you, it's me. Please don't persist to DB"


            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
        }


        // return response()->json(['list_data' => $data]);
    }



    public function paymentBondlist()
    {


        $payable = DB::table('payable_notes')
            ->join('purchases', 'purchases.id', '=', 'payable_notes.purchase_id')
            ->join('dailies', 'dailies.id', '=', 'payable_notes.daily_id')
            // ->join('payment_purchases', 'payment_purchases.purchase_id', '=', 'purchases.id')
            ->select(
                'purchases.supplier_name',
                'purchases.id as purchase_id',
                'payable_notes.*',
                'dailies.total',
            )
            ->paginate(10);

        return response()->json(['payable' => $payable]);
    }

    
}
