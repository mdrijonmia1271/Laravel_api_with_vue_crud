<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserDestroyController extends Controller
{
    public function __invoke($id=null){
        User::findOrFail($id)->delete();
        $message = 'User Successfully Deleted';
        return response()->json(['message'=>$message],200);
    }
}
