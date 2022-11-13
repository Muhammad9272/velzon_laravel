<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\SubPlan;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Session;
class DashboardController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('vendorhasactiveplan');
        $this->request = $request;
    }

   public function index($value='')
   {   
       $gs=GeneralSetting::find(1);
       $link=route('front.index').'?reff='.Auth::user()->affilate_code;
            $title=$gs->name;
            $socialShare = \Share::page($link,$title)
            ->facebook()
            ->twitter()
            // ->reddit()
            ->linkedin()
            ->whatsapp()
            ->getRawLinks();
            // ->telegram();
       return view('user.dashboard',compact('socialShare'));
   }

    public function profile()
    {
        $data = Auth::user();  
        return view('user.profile',compact('data'));
    }

    public function profileupdate(Request $request)
    {
        //--- Validation Section
        //--- Validation Section
        $request->validate([
         'avatar' => 'mimes:jpeg,jpg,png,svg',
         'email' => 'unique:users,email,'.Auth::user()->id,
        ]);

        //--- Validation Section Ends
        $input = $request->all();
        $data = Auth::user();
            if ($file = $request->file('avatar'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/front/images/users/',$name);
                if($data->avatar != null)
                {
                    if (file_exists(public_path().'assets/front/images/users/'.$data->avatar)) {
                        unlink(public_path().'assets/front/images/users/'.$data->avatar);
                    }
                }
            $data->avatar = $name;
            }

        $data->update($input);
        Session::flash('message', 'Data Updated Successfully !');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function resetform()
    {
        return view('user.cpassword');
    }

    public function reset(Request $request)
    {
       $request->validate([
         'cpass'=>'required',
         'newpass'=>'required',
         'renewpass' => 'required|same:newpass'
        ]);
        $user = Auth::user();
        if ($request->cpass){
            if (Hash::check($request->cpass, $user->password)){
                    $input['password'] = Hash::make($request->newpass);               
            }else{
               Session::flash('message', 'Current password Does not match.');
               Session::flash('alert-class', 'alert-danger');
               return redirect()->back();
            }
        }
        $user->update($input);
        Session::flash('message', 'Successfully change your password');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }


    // public function pricingDetails($id)
    // {
    //    $gs = GeneralSetting::firstOrFail();
    //    $ins=\Stripe\Stripe::setApiKey($gs->stripe_secret);
    //    $data=SubPlan::find($id);
    //    return view('front.subplandetails', [
    //       'intent' => auth()->user()->createSetupIntent(),
    //       'data'=>$data,
    //       'key'=>$gs->stripe_key,
    //    ]);
      
    // }

    // public function activateplan($id)
    // {
    //    $gs = GeneralSetting::firstOrFail();
    //    $ins=\Stripe\Stripe::setApiKey($gs->stripe_secret);
       
    //    if (! $this->request->payment_method) {
    //      return response()->json([
    //        "success" => false
    //      ]);
    //    }
    //    if (! auth()->user()->hasPaymentMethod()) {
    //        auth()->user()->createOrGetStripeCustomer();
    //    }

    //    try {
    //      auth()->user()->deletePaymentMethods();
    //    } catch (\Exception $e) {
    //      // error
    //    }

    //    auth()->user()->updateDefaultPaymentMethod($this->request->payment_method);
    //    auth()->user()->save();

    //    return response()->json([
    //      "success" => true
    //    ]);
    // }


}
