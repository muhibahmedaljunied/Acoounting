<?php

namespace App\Http\Controllers\Account;
use App\Repository\Note\ExpenceRepository;
use App\Services\CoreService;
use App\Models\Expence;
use App\Models\ExpenceType;
use App\Services\DailyService;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ExpenceController extends Controller
{
    
    public function __construct(Request $request,public CoreService $core)
    {

        $this->core->setData($request->all());
        
    }
   
    public function index()
    {

        // $Expences = staff::with(['Expence','Expence.Expence_type'])->paginate(10);


        // 
        // $Expences = Staff::with('Expences')
        //     ->paginate(10);

        // $Expences = DB::table('Expences')
        // ->join('Expence_types','Expence_types.id', '=', 'Expences.Expence_type_id')
        // ->join('staff','staff.id', '=', 'Expences.staff_id')
        // ->select('Expences.*','Expence_types.name as Expence','staff.*')
        // ->paginate(10);

        $expence_types = ExpenceType::all();
        // $staffs = Staff::all();
        return response()->json(['expence_types' => $expence_types]);
    }

    public function store(
        DailyService $daily,
        ExpenceRepository $note)
    {


        // $validator = Validator::make($request->all(), [
        //     'expence_type' => 'required',
        //     'qty' => 'required',
            
        // ]);

        // if($validator->fails()){
        //     return response()->json(['error' => $validator->errors()], 401);
        // }


        // dd($this->core->data);
        
        try {
            DB::beginTransaction(); // Tell Laravel all the code beneath this is a transaction


            $daily->daily()->debit()->credit();
            $note->finish();
         
            // dd(1);
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

    }

    
    

    public function show(Expence $Expence)
    {
         $expences = DB::table('expences')
        ->join('dailies','dailies.id', '=', 'expences.daily_id')
        ->join('daily_details','daily_details.daily_id', '=', 'dailies.id')
        ->join('accounts','accounts.id', '=', 'daily_details.account_id')
        ->select('expences.*','dailies.*','daily_details.debit','accounts.*')
        ->paginate(10);

        return response()->json(['expences' => $expences]);
    }

    
    public function edit(Expence $Expence)
    {
        //
    }

    
    public function update(Request $request, Expence $Expence)
    {
        //
    }

   
    public function destroy(Expence $Expence)
    {
        //
    }
}
