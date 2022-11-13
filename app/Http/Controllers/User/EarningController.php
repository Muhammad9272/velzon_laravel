<?php

namespace App\Http\Controllers\User;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\Withdraw;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Session;
class EarningController extends Controller
{
    public function __construct(GeneralSetting $settings,Request $request){
        $this->middleware('vendorhasactiveplan');
        $this->request = $request;
        $this->settings = $settings::first();
    }

    public function datatables()
    {   
        $datas=Transaction::where('referrer_link',Auth::user()->affiliate_code)->where('status','active')->orderBy('id','desc')->get();  
        return DataTables::of($datas)
                             ->addIndexColumn()
                             ->editColumn('earning_net_user', function(Transaction $data) {
                                return AppHelper::setCurrency($data->earning_net_user);
                             })
                             ->addColumn('status', function(Transaction $data) {
                                 $gs=GeneralSetting::find(1);

                                 $datenow=Carbon::now()->subDays($gs->withdrawl_after_days);
                                 if($data->created_at<=$datenow){
                                    if($data->is_cleared==1){
                                        return "<span class='badge text-bg-success'>Approved & Cleared</span>";
                                    }else{
                                        return "<span class='badge badge-soft-success badge-border'>Approved</span>";
                                    }                                   
                                 }else{
                                    return "<span class='badge badge-soft-secondary badge-border'>Pending Clearance</span>";
                                 }
                                 
                             })
                             ->addColumn('date', function(Transaction $data) {
                                $gs=GeneralSetting::find(1);
                                 return Carbon::parse($data->created_at)->addDays($gs->withdrawl_after_days)->format('F d, Y');
                             })
                            ->rawColumns(['status','earning_net_user','date'])
                            ->toJson(); //--- Returning Json Data To Client Side

       
    }

    public function index()
    {   
        return view('user.earnings.index');
    }

        // Stripe Payouts
    public function addPayGateway()
    {       
            $user=Auth::user();  
            //$stripe=AppHelper::stripekeys();
            $ins=\Stripe\Stripe::setApiKey($this->settings->stripe_secret);
            
            if(!Auth::user()->stripe_connect_key){                
                $account = \Stripe\Account::create([
                  'country' => 'US',
                  'email'=>$user->email,
                  'type' => 'express',
                ]);

                $user->stripe_connect_key=$account->id;
                $user->update();
            }
            if($user->stripe_connect_status!='completed'){
                $connect_key=$user->stripe_connect_key;
                $account_links = \Stripe\AccountLink::create([
                  'account' =>$connect_key ,
                  'refresh_url' => route('user.addpayment.gateway'),
                  'return_url' =>  route('user.returnpayment.gateway.status'),
                  'type' => 'account_onboarding',
                ]);

                return redirect($account_links->url);
            }
    }
    public function returnConnectStatus()
    {       
            $user=Auth::user(); 
            //$stripe=AppHelper::stripekeys();
            $ins=\Stripe\Stripe::setApiKey($this->settings->stripe_secret);
            $connect_key=$user->stripe_connect_key;
            $acc = \Stripe\Account::retrieve(
              $connect_key,
              []
            );
            if(($acc->details_submitted) && ($acc->charges_enabled)){
                $user->stripe_connect_status='completed';
                $user->update();

                toastr()->success('Payment Gateway added Successfully');
                return redirect()->route('user.earnings');            
            } 
            else{
                toastr()->error('Information missing, Please Try again !!');
                return redirect()->route('user.earnings');   
            }
    }
    public function sendPayUser()
    {
        
        $user=Auth::user(); 
        $ins=\Stripe\Stripe::setApiKey($this->settings->stripe_secret);

        $connect_key=$user->stripe_connect_key;
        $balance=\Stripe\Balance::retrieve();
        $balance=$balance->available[0]->amount;
        $balance=($balance/100);
        $current_balance=$user->userbalance();
        if(!Auth::user()->stripe_connect_key && !Auth::user()->stripe_connect_status=='completed'){
            toastr()->error('Invalid Request');
            return redirect()->route('user.earnings'); 
        }
        if($current_balance<=$this->settings->min_withdraw){
            toastr()->error('Your balance must be greater than '.AppHelper::setCurrency($this->settings->min_withdraw));
            return redirect()->route('user.earnings'); 
        }
        if($balance>=$current_balance){
            // Payout to user
            $transfer = \Stripe\Transfer::create([
              "amount" => $current_balance*100,
              "currency" => $this->settings->currency_code,
              "destination" => $connect_key,
              'description'=>'Payment from '.$this->settings->name.'To User '.$user->name,
            ]);
            //dd($transfer);
                
                $user_remaining_balance=$user->userbalancedecrement();

                $newwithdraw = new Withdraw();
                $newwithdraw['user_id'] = Auth::user()->id;
                $newwithdraw['method'] = "Stripe";
                $newwithdraw['transfer_id'] = $transfer->id;
                $newwithdraw['balance_transaction'] = $transfer->balance_transaction;
                $newwithdraw['destination'] = $transfer->destination;
                $newwithdraw['destination_payment'] = $transfer->destination_payment;
                $newwithdraw['live_mode'] = $transfer->live_mode?1:0;

                $newwithdraw['amount'] =  number_format(($transfer->amount/100),2);
                $newwithdraw['fee'] = 0;
                $newwithdraw['type'] = 'vendor';
                $newwithdraw['status'] ='completed';
                $newwithdraw->save();

                // $user->current_balance=$user->current_balance-($transfer->amount/100);
                // $user->update();

                // $gs = Generalsetting::findOrFail(1);
                // if($gs->is_smtp == 1)
                // {
                //     $emaildata = [
                //         'to' => Auth::user()->email,
                //         'type' => "withdrawal_email",
                //         'cname' => Auth::user()->name,
                //         'oamount' => "",
                //         'aname' => "",
                //         'aemail' => "",
                //         'onumber' => "",
                //         'token' => "",
                //         'transfer_amount'=>number_format(($transfer->amount/100),2),
                //         'transfer_id'=>$transfer->id,
                //     ];    
                //     $mailer = new GeniusMailer();
                //     $mailer->sendAutoMail($emaildata);
              
                // }
            Session::flash('message','Your withdrawal has been initiated.Please allow 1-2 business days for funding.' );
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('user.earnings');
        }
        else{
            toastr()->error('Sorry, Insufficient Funds for Withdrawal');
            return redirect()->route('user.earnings');
        }
       


    }

    //Stripe Payouts ends

}
