<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use Hash;
use Auth;

class AdminController extends Controller {
    public function register( Request $request ) {
        return view( 'Register' );
    }

    public function RegisterSave( Request $request ) {
                 
        $validate = $request->validate( [
            'name'=>'required|min:3|max:25',
            'email'=>'required|email',
            'password'=>'required|required_with:confirm_password|string|min:6|max:10',
            'confirm_password'=>'required|min:6|max:10'

        ] );
         
        $alreadyexists = Admin::where( 'email', $request->email )->first();
        if ( $alreadyexists ) {

            return redirect()->back()->with('error', 'User already Exists!');
        } else {
            $data = Admin::create( [
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ] )->save();
            if ( $data ) {
                return redirect()->back()->with('msg', 'User Created Successfully' );
            } else {
                return redirect()->back()->with('error', 'User Create Failed' );
            }

        }

    }

    public function login(){
        return view('Login');
    }

    public function authenticate(Request $request)
    {
        $credintial = ['email'=>$request->email,'password' =>$request->password];
       
        if (Auth::guard('admin')->attempt($credintial)) {
              
             return redirect()->route('dashboard');
          }else{
            return redirect()->route('login');
          }
    }

    public function dashboard()
    {
        return view('Admin.Dashboard');
       
    }
}

