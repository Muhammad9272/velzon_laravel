<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
class LoginController extends Controller
{

    public function __construct()
    {
         $this->middleware('guest')->only('showLoginForm');
    }

    public function showLoginForm()
    {
      return view('front.login');
    }

    public function login(Request $request)
    {      
        $this->validate($request,
          [
                  'email'   => 'required|email',
                  'password' => 'required'
                ]);

      // Attempt to log the user in
      if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        // if successful, then redirect to their intended location
        return redirect()->route('front.index');
      }
      Session::flash('message', 'Credentials Doesn\'t Match !');
      Session::flash('alert-class', 'alert-danger');
      return redirect()->back();

    }
    public function logout($value='')
    {   
        Auth::guard('web')->logout();
        return redirect()->route('front.index');
    }
}
