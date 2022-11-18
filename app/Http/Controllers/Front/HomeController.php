<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\SubFeature;
use App\Models\SubPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Session;
use Auth;
class HomeController extends Controller
{
    public function index(Request $request)
    {   
        if(!empty($request->reff))
         {
            $affiliate_user = User::where('affiliate_code','=',$request->reff)->first();
            if(!empty($affiliate_user))
            {
                $gs = GeneralSetting::findOrFail(1);
                if($gs->is_affilate == 1)
                {
                    Session::put('affilate', $affiliate_user->affiliate_code);
                    return redirect()->route('front.index');
                }

            }

         }   
      if(Auth::check() && Auth::user()->userSubscriptions()->exists()) {
        return redirect()->route('front.category');
      }  
      return view('front.index');
    }
}
