<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;




class PeriodServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {


        // $request = app(\Illuminate\Http\Request::class);

        // dd($request['year']);

        // if ($request['year']) {


        //     $database_old = Config::get("database.connections.mysql.database");
        //     Config::set("database.connections.mysql.database", 'warehouse' . $request['year']);
        //     $database = 'warehouse' . $request['year'];
        //     // Create connection
        //     $conn = new mysqli(
        //         Config::get("database.connections.mysql.host"),
        //         Config::get("database.connections.mysql.username"),
        //         Config::get("database.connections.mysql.password")
        //     );
        //     // Check connection
        //     if ($conn->connect_error) {
        //         die("Connection failed: " . $conn->connect_error);
        //     }

        //     // Create database
        //     $sql = "CREATE DATABASE " . $database;
        //     if ($conn->query($sql) === TRUE) {
        //         echo "Database created successfully";
        //     } else {
        //         echo "Error creating database: " . $conn->error;
        //     }

        //     $conn->close();

        //     // Config::set("database.connections.mysql.database",'warehouse'.$year);
        //      Artisan::call('migrate');
        //     Config::set("database.connections.mysql.database", $database_old);
        // }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {




        DB::listen(function ($query) {
            Log::info(
                $query->sql,
                $query->bindings,
                $query->time
            );
        });
    }
}
