<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditedValidated;
use App\Http\Requests\MultipleValidated;
use App\Http\Requests\UserValidation;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;

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

        // return response()->json([
        //     'message' => 'Password reset email sent.',
        //     'data' => $response,
        // ]);


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
                'message'=>'User Successfully Added'
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
        $message = 'User Successfully Added';
        return response()->json(['message'=>$message],201);
        }
    }

    //Put api for add update user details
    public function edit(EditedValidated $request,$id){
        if($request->isMethod('put')){
            $data = $request->all();
            // return $data;
    
            $user = User::findOrFail($id);
            $user->name = $data['name']; 
            $user->email = $data['email']; 
            $user->save();
            return response()->json([
                'message'=>'User Successfully Updated'
            ],202);
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
