<?php

namespace App\Http\Controllers\Account;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use App\Models\AccountYear;
use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysqli;
class PeriodController extends Controller
{







    public function index(){



        $periods =  AccountYear::all();

       
        return response()->json([
            'account_years' => $periods
        ]);

    }

    public function create_new_year($year)
    {

        Config::set("database.connections.mysql2.database", 'warehouse'.$year);
        // dd(env('DB_DATABASE', 'forge'));

        // Create connection
        $conn = new mysqli(
            Config::get("database.connections.mysql.host"),
            Config::get("database.connections.mysql.username"),
            Config::get("database.connections.mysql.password")
        );
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Create database
        $sql = "CREATE DATABASE ".'warehouse'.$year;
        if ($conn->query($sql) === TRUE) {
            echo "Database created successfully";
        } else {
            echo "Error creating database: " . $conn->error;
        }

        $conn->close();
        Artisan::call("migrate --database=mysql2");
        // Artisan::call("db:seed --database=mysql2");
        Config::set("database.connections.mysql2.database", env('DB_DATABASE', 'forge'));
    }

    public function init_new_year_data($data)
    {


   

        foreach ($data['data'] as $value) {
                    
       
            $table = DB::connection('mysql')->select('select * from '.$value);
            foreach ($table as $record) {
                DB::connection('mysql2')
                    ->table($value)
                    ->insert(get_object_vars($record));
            }
        }


    }
   



    public function create_account_year($request){

        $account = new AccountYear();
        $account->name = $request['year'];
        $account->start_date = $request['start_date'];
        $account->end_date = $request['end_date'];
        $account->status = 0;
        $account->save();
    }

    public function store_account_period(Request $request)
    {


        // dd($request['data']);

     $this->create_account_year($request);


        if ($request['year']) {

            $this->create_new_year($request['year']);
        }

        $this->init_new_year_data($request);

        // Cache::forget('tree_accounts');
        // Cache::forget('tree_accounts_node');

        return response()->json($request->all());
    }







    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Account  $account
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {

        $account = Account::find($id);
        return response()->json(['account' => $account]);
    }

    public function account_edit_node(Request $request, $id)
    {

        $data = Account::find($id);
        return response()->json(['data' => $data]);
    }





    public function destroy($id)
    {

        $product = Account::find($id);

        $product->delete();
    }
}
