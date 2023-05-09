<?php

namespace App\Http\Controllers;

use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{
    public function index($id=null){
        if($id==''){
            $users = User::get();
            return response()->json(['users'=>$users],200);
        }else{
            $users = User::find($id);
            return response()->json(['users'=>$users],200);
        }
    }
    public function create(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // return $data;

            $rules = [
                'name'=>'required',
                'email'=>'required|email|unique:users',
                'password'=>'required',
            ];

            $customeMessage = [
                'name.required'=>'Name is required',
                'email.required'=>'Email is required',
                'email.email'=>'Email must be a valid email',
                'password.required'=>'Password is required',
            ];

            $validator = Validator::make( $data,$rules,$customeMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }

            $user = new User();
            $user->name = $data['name']; 
            $user->email = $data['email']; 
            $user->password = bcrypt($data['password']); 
            $user->save();
            $message = 'User Successfully Added';
            return response()->json(['message'=>$message],201);
        }
    }
    
    //post api for multiple user
    public function createMultiple(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // return $data['users'];
            
            $rules = [
                'users.*.name'=>'required',
                'users.*.email'=>'required|email|unique:users',
                'users.*.password'=>'required',
            ];
            
            $customeMessage = [
                'users.*.name.required'=>'Name is required',
                'users.*.email.required'=>'Email is required',
                'users.*.email.email'=>'Email must be a valid email',
                'users.*.password.required'=>'Password is required',
            ];
            
            $validator = Validator::make( $data,$rules,$customeMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }
            
            foreach($data['users'] as $adduser){
                $user = new User();
            $user->name = $adduser['name']; 
            $user->email = $adduser['email']; 
            $user->password = bcrypt($adduser['password']); 
            $user->save();
        }
        $message = 'User Successfully Added';
        return response()->json(['message'=>$message],201);
        }
    }

    //Put api for add update user details
    public function edit(Request $request,$id){
        if($request->isMethod('put')){
            $data = $request->all();
            // return $data;
    
            $rules = [
                'name'=>'required',
                'email'=>'required',
            ];
    
            $customeMessage = [
                'name.required'=>'Name is required',
                'email.required'=>'Email is required',
            ];
    
            $validator = Validator::make($data,$rules,$customeMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }
    
            $user = User::findOrFail($id);
            $user->name = $data['name']; 
            $user->email = $data['email']; 
            $user->save();
            $message = 'User Successfully Updated';
            return response()->json(['message'=>$message],202);
        }
    }

   //Patch api for update single record
    public function update(Request $request,$id){
        if($request->isMethod('patch')){
            $data = $request->all();
            // return $data;
    
            $rules = [
                'name'=>'required',
            ];
    
            $customeMessage = [
                'name.required'=>'Name is required',
            ];
    
            $validator = Validator::make($data,$rules,$customeMessage);
            if($validator->fails()){
                return response()->json($validator->errors(),422);
            }
    
            $user = User::findOrFail($id);
            $user->name = $data['name']; 
            $user->save();
            $message = 'User Successfully Updated';
            return response()->json(['message'=>$message],202);
        }
    }
    public function destroy($id=null){
        User::findOrFail($id)->delete();
        $message = 'User Successfully Deleted';
        return response()->json(['message'=>$message],200);
    }

    //Delete User With Json
    public function deleteSingleUserWithJson(Request $request){
        if($request->isMethod('delete')){
            $data = $request->all();
            User::where('id',$data['id'])->delete();
            $message = 'User Successfully Deleted';
            return response()->json(['message'=>$message],200);
        }
    }

    //Delete Multiple User
    public function deleteMultipleUser($ids){
        $ids = explode(',',$ids);
        User::whereIn('id',$ids)->delete();
        $message = 'User Successfully Deleted';
        return response()->json(['message'=>$message],200);
    }

    //Delete MUltiple user with json
    public function deleteMultipleUserWithJson(Request $request){

        $header = $request->header('Authorization');
        if($header==''){
            $message = 'Authorization is required';
            return response()->json(['message'=>$message],422);
        }else{
            //user Jwt-----
            if($header=='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c'){
                if($request->isMethod('delete')){
                    $data = $request->all();
                    User::whereIn('id',$data['ids'])->delete();
                    $message = 'User Successfully Deleted';
                    return response()->json(['message'=>$message],200);
                }
            }else{
                $message = 'Authorization does not match';
                return response()->json(['message'=>$message],422);
            }
        }
        
    }

}
