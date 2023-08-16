<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
// use App\Exports\StatusExport;
// use App\Imports\StatusImport;
use Maatwebsite\Excel\Facades\Excel;
use Storage;
use DB;

class StatusController extends Controller
{
    public function index()
    {
         

        $status = DB::table('statuses')
        ->select('statuses.*')
        ->paginate(10);
        return response()->json($status);

    }

     public function search(Request $request)      
    {      
        $status = Status::where('statuss.name', 'LIKE', '%'.$request->post('word_search').'%')
        ->select('statuses.*')
        ->paginate(10);
        return response()->json($status);

        

    }


    public function store(Request $request)
    {
        $status = new Status();
        $status->name = $request->post('name');


        $status->save();

        return response()->json($status);    
    
    }

    // public function Export( )      
    // {      
    //     $filename = '-status.xlsx';
    //     Excel::store(new StatusExport, $filename);
    //     $fullPath = Storage::disk('local')->path($filename);

    //     return response()->json([
    //         'data' => $fullPath,
    //         'message' => 'stores are successfully exported.'
    //     ], 200);

    // }

    // public function Import(Request $request)
    // {

    //     $filename = '-status.xlsx';
    //     return response()->json(Excel::import(new StatusImport,Storage::disk('local')->path($filename)));
       
    // }


    public function edit($id)
    {
        $status = Status::find($id);
        return response()->json(['statuses'=>$status]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $status = Status::find($request->id);
        $status->update($request->post());
        return response()->json($request->post());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = Status::find($id);

        $status->delete();

        return response()->json('successfully deleted');
    }

}
