<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function register(){
        return view('auth.register');
    }

    public function registeruser(RegisterRequest $request){
        User::create($request->validated());
    }
}
