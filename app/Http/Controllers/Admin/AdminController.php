<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\SocialSetting;
use App\Models\Transaction;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;

class AdminController extends Controller
{  
   public function __construct(){

     $this->middleware('auth:admin');
   }
   
   public function index($value='')
   {  
      $usercount=User::all()->count();
      $earning_net_admin=Transaction::where('status','active')->sum('earning_net_admin');
      $earning_net_user=Transaction::where('status','active')->sum('earning_net_user');
      $earning_net_user=Transaction::where('status','active')->sum('earning_net_user');
      $listing_count=Product::all()->count();
      return view('admin.dashboard',compact('usercount','earning_net_admin','earning_net_user','listing_count'));
   }
   
   public function generalsettings(Request $request)
   {  
      $data=GeneralSetting::find(1);
      return view('admin.generalsettings',compact('data'));
   }

   public function generalsettingsupdate(Request $request)
   {    
       //dd($request->all());
        //--- Validation Section
        $request->validate([
         'favicon' => 'mimes:jpeg,jpg,png,svg',
         'logo' => 'mimes:jpeg,jpg,png,svg',
        ]);
       
       
        //--- Validation Section Ends
        $input = $request->all();
        $data = GeneralSetting::find(1);
            if ($file = $request->file('favicon'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images/',$name);
                if($data->favicon != null)
                {
                    if (file_exists(public_path().'/assets/images/'.$data->favicon)) {
                        unlink(public_path().'/assets/images/'.$data->favicon);
                    }
                }
                $data->favicon = $name;
            }
            if ($file = $request->file('logo'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images/logo/',$name);
                if($data->logo != null)
                {
                    if (file_exists(public_path().'/assets/images/logo/'.$data->logo)) {
                        unlink(public_path().'/assets/images/logo/'.$data->logo);
                    }
                }
                $data->logo = $name;
            }
            if ($file = $request->file('admin_logo'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images/logo/',$name);
                if($data->admin_logo != null)
                {
                    if (file_exists(public_path().'/assets/images/logo/'.$data->admin_logo)) {
                        unlink(public_path().'/assets/images/logo/'.$data->admin_logo);
                    }
                }
                $data->admin_logo = $name;
            }


         $data->name=$request->name;   
         $data->slogan=$request->slogan;   
         $data->update();

      Session::flash('message', 'Successfully updated Data');
      Session::flash('alert-class', 'alert-success');
      return redirect()->back();
   }
   
   public function passwordreset($value='')
   {
      return view('admin.cpassword');
   }

   public function changepass(Request $request)
   {    
        $request->validate([
         'cpass'=>'required',
         'newpass'=>'required',
         'renewpass' => 'required|same:newpass'
        ]);
        $admin = Auth::guard('admin')->user();
        if ($request->cpass){
            if (Hash::check($request->cpass, $admin->password)){
                    $input['password'] = Hash::make($request->newpass);               
            }else{
               Session::flash('message', 'Current password Does not match.');
               Session::flash('alert-class', 'alert-danger');
               return redirect()->back();
            }
        }
        $admin->update($input);
        Session::flash('message', 'Successfully change your password');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function profile()
    {
        $data = Auth::guard('admin')->user();
        return view('admin.profile',compact('data'));
    }

    public function profileupdate(Request $request)
    {
        //--- Validation Section
        $request->validate([
         'photo' => 'mimes:jpeg,jpg,png,svg',
         'email' => 'unique:admins,email,'.Auth::guard('admin')->user()->id
        ]);

        //--- Validation Section Ends
        $input = $request->all();
        $data = Auth::guard('admin')->user();
            if ($file = $request->file('photo'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images/admins/',$name);
                if($data->photo != null)
                {
                    if (file_exists(public_path().'/assets/images/admins/'.$data->photo)) {
                        unlink(public_path().'/assets/images/admins/'.$data->photo);
                    }
                }
            $data->photo = $name;
            }

        $data->update($input);
        Session::flash('message', 'Data Updated Successfully !');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
       
    }

    public function social($value='')
    { 
      $data=SocialSetting::find(1);
      return view('admin.socialsettings',compact('data'));
    }

    public function socialupdate(Request $request)
    {   
        $input = $request->all();
        $data = SocialSetting::find(1);

        $data->update($input);
        Session::flash('message', 'Data Updated Successfully !');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }
    
    

}
