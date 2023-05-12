<?php

namespace App\Http\Controllers;

use App\Http\Requests\MultipleValidated;
use App\Http\Requests\UserValidation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserApiController extends Controller
{
    public function index($id=null){
        if($id==''){
            return response()->json([
                'users'=>User::get()
            ],200);
        }else{
            return response()->json([
                'users'=>User::find($id)
            ],200);
        }

    }
    public function create(UserValidation $request){
        if($request->isMethod('post')){
            $data = $request->all();
    
            $user = new User();
            $user->name = $data['name']; 
            $user->email = $data['email']; 
            $user->password = bcrypt($data['password']); 
            $user->save();
            return response()->json([
                'message'=>'User Successfully Added',
            ],201);
        }
    }
    
    //post api for multiple user
    public function createMultiple(MultipleValidated $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // return $data['users'];
            
            foreach($data['users'] as $adduser){
                $user = new User();
            $user->name = $adduser['name']; 
            $user->email = $adduser['email']; 
            $user->password = bcrypt($adduser['password']); 
            $user->save();
        }
        return response()->json([
            'message'=>'User Successfully Added'
        ],201);
        }
    }



}
