<?php

namespace App\Http\Controllers\Front;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\GeneralSetting;
use App\Models\SubFeature;
use App\Models\SubPlan;
use App\Models\Subscriptions;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Session;
class StripeController extends Controller
{
    public function __construct(GeneralSetting $settings, Request $request)
    {   
        $this->middleware('auth');
        $this->settings = $settings::first();
        $this->request = $request;   
    }

    public function pricing($value='')
    { 
      $checkSubscription = auth()->user()->subscriptionsActive();
      $datas=SubPlan::where('status',1)->get(); 
      $subfeatures=SubFeature::where('status',1)->get();
      $gs = GeneralSetting::firstOrFail();
      // $ins=\Stripe\Stripe::setApiKey($gs->stripe_secret);
      return view('front.pricing', [
          'key'=>$gs->stripe_key,
          'datas'=>$datas,
          'subfeatures'=>$subfeatures,
          'checkSubscription'=>$checkSubscription,
      ]);

    }
    
    public function pricingDetails($id)
    {
      $gs = GeneralSetting::firstOrFail();
      $ins=\Stripe\Stripe::setApiKey($gs->stripe_secret);
      $data=SubPlan::find($id);
      return view('front.subplandetails', [
          'intent' => auth()->user()->createSetupIntent(),
          'data'=>$data,
          'key'=>$gs->stripe_key,
      ]);
      
    }

    protected function activateplan($id)
    {
        //date_default_timezone_set("Asia/Karachi");
        // if (!$this->request->expectsJson()) {
        //     abort(404);
        // }
       
        // if (!auth()->user()->hasPaymentMethod()) {
        //     return response()->json([
        //         "success" => false,
        //         'errors' => ['error' => "Please Add Payment Gateway"]
        //     ]);
        // }
        $errorifany=$this->addUpdatePaymentCard();
        if(isset($errorifany) && $errorifany['success']==0){
                Session::flash('message', $errorifany['msg']);
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
        }
        // Check if Plan exists

        $subexists=auth()->user()->userSubscriptions()->where('cancelled',0)->first();       
        if($subexists){
            $errorifany=$this->deleteprevious();
            if(isset($errorifany) && $errorifany['success']==0){
                Session::flash('message', $errorifany['msg']);
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
            
        }
        // Find the user to subscribe
        $user = Admin::find(1);

        // Check if Plan exists
        $plan = SubPlan::findOrFail($id);

        $gs = GeneralSetting::first();
        $stripe = new \Stripe\StripeClient($gs->stripe_secret);
        $userPlan = $plan->name;
        

        // Verify Plan Exists
        try {
            $planCurrent = $stripe->plans->retrieve($userPlan, []);
            $pricePlanOnStripe = ($planCurrent->amount / 100);

            // We check if the plan changed price
            if ($pricePlanOnStripe != $plan->price) {
                // Delete old plan
                $stripe->plans->delete($userPlan, []);

                // Delete Product
                $stripe->products->delete($planCurrent->product, []);

                // We create the plan with new price
                $this->createPlan($gs->stripe_secret, $plan, $user);
            }
        } catch (\Exception $exception) {
            // Create New Plan
            $this->createPlan($gs->stripe_secret, $plan, $user);
        }

        try {

            // Check Payment Incomplete
            if (auth()->user()
                ->userSubscriptions()
                ->where('cancelled',0)
                ->where('stripe_price', $userPlan)
                ->whereStripeStatus('incomplete')
                ->first()
            ) {
                Session::flash('message', 'Please confirm the payment');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();  
            }

            // Create New subscription
            $metadata = [
                'interval' => $plan->interval,
                'taxes'   =>'',
                // 'taxes' => auth()->user()->taxesPayable()
            ];
            
            if($plan->free_trial>0 && auth()->user()->freetrial()){
                 auth()->user()->newSubscription('main', $userPlan)
                ->withMetadata($metadata)
                // ->trialUntil(Carbon::now()->addMinutes(1))
                ->trialDays($plan->free_trial)
                ->create();
            }else{
                  auth()->user()->newSubscription('main', $userPlan)
                ->withMetadata($metadata)
                ->create();
            }
            
           
            // Send Email to User and Notification
            //Subscriptions::sendEmailAndNotify(auth()->user()->name, $user->id);

            Session::flash('message', 'Plan Activated Successfully!');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('front.category');

        } catch (IncompletePayment $exception) {

            // Insert ID Last Payment
            $subscriptions = Subscriptions::whereUserId(auth()->id())
                ->whereStripePrice($userPlan)
                ->whereStripeStatus('incomplete')
                ->first();

            $subscriptions->last_payment = $exception->payment->id;
            $subscriptions->save();

            // return response()->json([
            //     'success' => true,
            //     'url' => url('stripe/payment', $exception->payment->id), // Redirect customer to page confirmation payment (SCA)
            // ]);
            $url=url('stripe/payment', $exception->payment->id);
            return redirect()->to($url);

        } catch (\Exception $exception) {

            \Log::debug($exception);
            Session::flash('message', 'Unable to process request.Error:' . $exception->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect()->back();
        }
    } // End Method

    private function createPlan($keySecret, $plan, $user)
    {
        $stripe = new \Stripe\StripeClient($keySecret);

        switch ($plan->interval) {
            case 'daily':
                $interval = 'day';
                $interval_count = 1;
                break;
            case 'weekly':
                $interval = 'day';
                $interval_count = 7;
                break;

            case 'monthly':
                $interval = 'month';
                $interval_count = 1;
                break;

            case 'quarterly':
                $interval = 'month';
                $interval_count = 3;
                break;

            case 'biannually':
                $interval = 'month';
                $interval_count = 6;
                break;

            case 'yearly':
                $interval = 'year';
                $interval_count = 1;
                break;
        }
        // dd($plan);
        //$planid=str_slug($plan->name,'-').'-'.strtolower(str_random(3));
        // If it does not exist we create the plan
        $stripe->plans->create([
            'currency' => $this->settings->currency_code,
            'interval' => $interval,
            'interval_count' => $interval_count,
            "product" => [
                "name" => "Subscription For Plan @".$plan->name,
            ],
            'nickname' =>$plan->name,
            'id' =>  $plan->name,
            'amount' => $this->settings->currency_code == 'JPY' ? $plan->price : ($plan->price * 100),
        ]);
    }

    private function addUpdatePaymentCard()
    {
       $gs = GeneralSetting::firstOrFail();
       $ins=\Stripe\Stripe::setApiKey($gs->stripe_secret);
       
       if (!$this->request->payment_method) {
         $data['success']=0;
         $data['msg']="Payment Method Not Defined";
         return $data;
       }
       if (! auth()->user()->hasPaymentMethod()) {
           auth()->user()->createOrGetStripeCustomer();
       }

       try {
         auth()->user()->deletePaymentMethods();
       } catch (\Exception $e) {
         $data['success']=0;
         $data['msg']="Something Went Wrong.While adding Payment details";
         return $data;
       }

       auth()->user()->updateDefaultPaymentMethod($this->request->payment_method);
       auth()->user()->save();

       // return response()->json([
       //   "success" => true
       // ]);
    }

    protected function deleteprevious($id='')
    {   
        if($id){
           $checkSubscription=auth()->user()->userSubscriptions()->where('cancelled',0)->where('id',$id)->first(); 
        }else{
           $checkSubscription=auth()->user()->userSubscriptions()->where('cancelled',0)->orderBy('id','desc')->first(); 
        }        
        if($checkSubscription && $checkSubscription->stripe_id){     
           $stripe = new \Stripe\StripeClient($this->settings->stripe_secret);
           try {
             $response = $stripe->subscriptions->cancel($checkSubscription->stripe_id, []);
           } catch (\Exception $e) {
             $data['success']=0;
             $data['msg']=$e->getMessage();
             return $data;
           }           
        }

        if($checkSubscription){
           $checkSubscription->ends_at = date('Y-m-d H:i:s', $response->current_period_end);
           //custom new
           $checkSubscription->stripe_status=$response->status;
           $checkSubscription->cancelled=1;
           $checkSubscription->update();
        }
        // }else{
        //      $data['success']=0;
        //      $data['msg']="Previous Subscription Not Found";
        //      return $data;
        // }
    }

    public function subplanCancel($id)
    {   
     
        $errorifany=$this->deleteprevious($id);
        if(isset($errorifany) && $errorifany['success']==0){
            return response()->json(['success'=>0,'msg'=>$errorifany['msg']]);
        }else{
           return response()->json(['success'=>1,'msg'=>'You have Unsubscribed Successfully!']); 
        }

    }

}
