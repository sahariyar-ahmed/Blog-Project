<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class GuestAuthentication extends Controller
{
    public function register(){
        return view('frontend.auth.register');
    }

    public function register_post(Request $request){
        $request->validate([
            "*" => "required",
        ]);


        User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'created_at' => now(),
        ]);

        return redirect()->route('guest.login')->with('register_success', 'Registration successfull');
    }


    public function login(){
        return view('frontend.auth.login');
    }

    public function login_post(Request $request){
        $request->validate([
            "*" => "required",
        ]);

        if(Auth::attempt(["email"=> $request->email,"password"=> $request->password])){
            return redirect()->route('dashboard');
        }else{
            return back()->withErrors(['email'=> 'User is not valid'])->withInput();
        }
    }





}
