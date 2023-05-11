<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditedValidated;
use App\Models\User;

class UserEditController extends Controller
{
    public function __invoke(EditedValidated $request,$id){
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
}
