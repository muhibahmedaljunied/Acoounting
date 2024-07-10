<?php

namespace App\Http\Controllers\Purchase;

use App\Repository\Note\PaymentBondRepository;
use App\Services\UnitService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Purchase;
use App\Traits\Invoice\InvoiceTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\status;
use App\Services\CoreService;
use App\Services\DailyStockService;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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



        $data = Payment::with(['Paymentable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                Purchase::class => function ($query) {

                    $query->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id');
                    $query->join('groups', 'groups.id', '=', 'suppliers.group_id');
                    $query->select(
                        'purchases.*',
                        'purchases.id as purchase_id',
                        'suppliers.name as supplier_name',
                        'suppliers.id as supplier_id',
                        'groups.account_id',
                    );
                },
            ]);
        }])
            ->where('paymentable_type', 'App\\Models\\Purchase')
            ->where('paymentable_id', $request->id)

            ->paginate(5);


        return response()->json(['list_data' => $data]);
    }

    public function store_PaymentBond(
        DailyStockService $dailyService,
        PaymentBondRepository $note

    ) {

        // dd($this->core->data);


        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction

            $dailyService->daily()->exicute('debit')->exicute('credit');
  
            $note->finish();
        
            $this->payment->update();
       
            // dd(123333333);


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

    public function get_payment_bond(Request $request)
    {



        $data = Payment::with(['Paymentable' => function (MorphTo $morphTo) {
            $morphTo->constrain([
                Purchase::class => function ($query) {

                    $query->join('suppliers', 'suppliers.id', '=', 'purchases.supplier_id');
                    $query->join('payable_notes', 'payable_notes.purchase_id', '=', 'purchases.id');
                    $query->select(
                        'purchases.*',
                        'purchases.id as purchase_id',
                        'suppliers.name as supplier_name',
                        'suppliers.id as supplier_id',
                        'payable_notes.id as payable_id'
                    );
                },
            ]);
        }])
            ->where('paymentable_type', 'App\\Models\\Purchase')
            ->where('paymentable_id', $request->id)
            ->paginate(5);


        return response()->json(['list_data' => $data]);
    }

    public function payment_bond_daily(Request $request){
        
        $payable_notes  = DB::table('payable_notes')->where('payable_notes.id', $request->id)
        ->join('dailies', 'dailies.id', '=', 'payable_notes.daily_id')
        ->join('daily_details', 'dailies.id', '=', 'daily_details.daily_id')
        ->join('accounts', 'accounts.id', '=', 'daily_details.account_id')
        ->select(
            'payable_notes.id as payabale_note_id',
            'dailies.*',
            'daily_details.*',
            'accounts.text',
            'accounts.id as account_id',
        )
        ->get();

    // dd($purchases);
    return response()->json(['daily_details' => $payable_notes]);
    }


    public function paymentBondlist()
    {


        $payable = DB::table('payable_notes')
            ->join('purchases', 'purchases.id', '=', 'payable_notes.purchase_id')
            ->join('dailies', 'dailies.id', '=', 'payable_notes.daily_id')
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
