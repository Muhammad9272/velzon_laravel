<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Session;
class RegisterController extends Controller
{
    public function __construct()
    {
         $this->middleware('guest');
    }

    public function showRegisterForm()
    {  
        return view('front.register');
    }

    public function register(Request $request)
    {   
        //--- Validation Section
        $request->validate([
            'name'=>'required',
            'email'   => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);
            $referred_by='';
            if(Session::has('affilate')){
              $referred_by=Session::get('affilate');
            }  

            $affiliate_code=substr(uniqid(), 0, 8);
            while($affiliate_user=User::where('affiliate_code', '=', $affiliate_code)->exists())
            {
             $affiliate_code=substr(uniqid(), 0, 8);
            }

          $user = new User;
          $input = $request->all();  
          $input['role_id']=1;      
          $input['password'] = bcrypt($request['password']);  
          $input['affiliate_code'] = $affiliate_code;  

          $input['referred_by'] = $referred_by;       
          $user->fill($input)->save();
          Auth::guard('web')->login($user);
          $redirectTo=route('front.pricing')."#form-wizard"; 
          return redirect()->to($redirectTo);
               
    }
}
