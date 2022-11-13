<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Subscriptions;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class UserController extends Controller
{
    public function __construct(){
     $this->middleware('auth:admin');
    }

    public function usersDataTables($value='')
    {   
        $datas=User::orderBy('id','desc')->get();  
        return DataTables::of($datas)
                            ->addIndexColumn()
                            
                            ->editColumn('created_at', function(User $data) {
                                return Carbon::parse($data->created_at)->format('F d, Y');
                            })
                            // ->addColumn('action', function(User $data) {
                            //     return '<div class="action-list">
                                
                            //     <a href="'.route('admin.users.transactions.index',$data->id).'" class="btn btn-info btn-sm fs-13 waves-effect waves-light">View Transactions</a> 

                            //     </div>';
                            // }) 
                            ->rawColumns(['created_at'])
                            ->toJson(); //--- Returning Json Data To Client Side
      
    }
    public function users($value='')
    {
        return view('admin.users.users');
    }

    public function subscribedusersDataTables($value='')
    {   
        $datas=Subscriptions::orderBy('id','desc')->get();  
        return DataTables::of($datas)
                            ->addIndexColumn()
                            ->editColumn('user_id', function(Subscriptions $data) {
                                return $data->relateduser?$data->relateduser->name:'Not Defined';
                            })
                            ->editColumn('stripe_status', function(Subscriptions $data) {
                                if($data->stripe_status=="active" || $data->stripe_status=="trialing")
                                {  
                                   if($data->stripe_status=="trialing"){
                                    $msg="<span class='badge badge-soft-secondary badge-border'>".Str::upper($data->stripe_status)."</span><br>";
                                    $msg.="<small>Trial Ends At: ".Carbon::parse($data->trial_ends_at)->format('F d, Y ')."</small>";
                                   }else{
                                     $msg="<span class='badge text-bg-success'>".Str::upper($data->stripe_status)."</span><br>";
                                     $msg.="<small>Ends At: ".Carbon::parse($data->ends_at)->format('F d, Y')."</small>";
                                   }
                                   return $msg;

                                }else{
                                   $msg="<span class='badge text-bg-danger'>".Str::upper($data->stripe_status)."</span><br>";
                                   // $msg.="<small>Ends At: ".Carbon::parse($data->ends_at)->format('F d, Y H:i A')."</small>";
                                   return $msg;
                                }
                                
                            })
                            ->editColumn('created_at', function(Subscriptions $data) {
                                return Carbon::parse($data->created_at)->format('F d, Y');
                            })
                            ->addColumn('action', function(Subscriptions $data) {
                                return '<div class="action-list">
                                
                                <a href="'.route('admin.users.transactions.index',$data->id).'" class="btn btn-info btn-sm fs-13 waves-effect waves-light">View Transactions</a> 

                                </div>';
                            }) 
                            ->rawColumns(['stripe_status','created_at','action'])
                            ->toJson(); //--- Returning Json Data To Client Side
      
    }
    public function subscribedusers($value='')
    {
        return view('admin.users.subscribed');
    }

    public function userstransactionsDataTables($id='')
    {   
        if($id){
         $subscription=Subscriptions::find($id);  
         $datas=Transaction::where('subscriptions_id',$subscription->id)->orderBy('id','desc')->get();
        }else{
         $datas=Transaction::orderBy('id','desc')->get();
        }          
        return DataTables::of($datas)
                            ->addIndexColumn()
                            ->editColumn('user_id', function(Transaction $data) {
                                return $data->relateduser?$data->relateduser->name:'Not Defined';
                            })
                            ->editColumn('amount', function(Transaction $data) {

                               if($data->status=="trialing"){
                                 $msg=AppHelper::setCurrency(0);
                                 $msg.="<br><span class='badge badge-soft-secondary badge-border'>".Str::upper($data->status)."</span>";
                               }else{
                                 $msg=AppHelper::setCurrency($data->amount);
                                 $msg.="<br><span class='badge text-bg-success'>".Str::upper($data->status)."</span>";
                               }
                               return $msg;                           
                            })
                            ->editColumn('earning_net_admin', function(Transaction $data) {
                                return AppHelper::setCurrency($data->earning_net_admin);
                            })
                            ->editColumn('referrer_link', function(Transaction $data) {
                                if($data->referrer_link){
                                    $userearn=AppHelper::setCurrency($data->earning_net_user);
                                    $msg="<span>Referrer Link :".$data->referrer_link."</span><br><span>Referrer Earning :".$userearn."</span>";
                                    return $msg;
                                }else{
                                    return "No Referral";
                                }
                                
                            })
                            ->editColumn('created_at', function(Transaction $data) {
                                return Carbon::parse($data->created_at)->format('F d, Y H:i A');
                            })
                            ->rawColumns(['earning_net_admin','referrer_link','amount','created_at'])
                            ->toJson(); //--- Returning Json Data To Client Side
      
    }
    public function userstransactions($id='')
    {
        return view('admin.users.transactions',compact('id'));
    }

}
