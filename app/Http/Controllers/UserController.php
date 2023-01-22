<?php

namespace App\Http\Controllers;

// use App\RepositoryInterface\UserRepositoryInterface;
use Illuminate\Http\Request;
// use App\RepositoryInterface\UsersRepositoryInterface;
use App\Models\User;
use App\Models\Role;
use DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

   
    public function index(){
    	
        $users = DB::table('roles')
        ->join('users','users.role_id', '=', 'roles.id')
        ->select('users.*','roles.name as role_name')
        ->paginate(10);
        return response()->json($users);  
    }

    public function search(Request $request)      
    {      
        

        $users = User::where('users.name', 'LIKE', '%'.$request->post('word_search').'%')
        ->join('roles','users.role_id', '=', 'roles.id')
        ->select('users.*','roles.name as role_name')
        ->paginate(10);
        return response()->json($users);

        

    }

    public function create(){
    	$roles = Role::all();
        return response()->json($roles);  
    }

    public function store(Request $request){


        $validator = Validator::make($request->all(), [
            'name' => 'required|max:10',
            'email' => 'required|email|unique:users',
            'phone'=>'required'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }


    	$user = new User();
        $user->name = $request->post('name');
        $user->phone = $request->post('phone');
        $user->email =$request->post('email');
        $user->password = bcrypt($request->post('password'));
        $user->address = $request->post('address');
        $user->role_id = $request->post('role_id');
        $user->status = $request->post('status');
        $user->save();

        return back();
    }

    public function edit(Request $request)
    {
        $user = User::where('users.id',$request->id)
        ->join('roles','users.role_id', '=', 'roles.id')
        ->select('users.*','roles.name as role_name')
        ->get();

        $role = Role::all();
        return response()->json(['user'=>$user,'role'=>$role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product = Product::find($request->id);
        $product->update($request->post());
        return response()->json($request);
    }
}
