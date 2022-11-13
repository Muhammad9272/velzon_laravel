<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
        protected function show($id)
    {
       
        // if (! $this->request->expectsJson()) {
        //     abort(404);
        // }
        $plan = AdminPlan::findOrFail($id);
        if (!auth()->user()->hasPaymentMethod() && $plan->price > 0) {
          
            \Session::flash('error_message', __('general.please_add_payment_card')."<a class='text-white' href=".route('users.my.cards')."><u> Click Here</u></a>");
            return redirect()->route('creator.sub.plans');
        }

        // Check if Plan exists
        $subexists=auth()->user()->userSubscriptions()->where('is_admin',1)->first();       
        if($subexists){
            $this->deleteprevious();
        }

        // Find the user to subscribe
        $user = Auth::user();
        
        //If Free plan
        if ($plan->price == 0) {
            return redirect()->route('creator.sub.free',$id);
        }
        //if free plan exists
        $allplans = AdminPlan::orderBy('price','asc')->get();  

        $payment = PaymentGateways::whereName('Stripe')->whereEnabled(1)->first();
        $stripe = new \Stripe\StripeClient($payment->key_secret);
        $userPlan = $plan->name;
        
        // Verify Plan Exists
        try {
            $planCurrent = $stripe->plans->retrieve($userPlan, []);
            // dd($planCurrent);
            $pricePlanOnStripe = ($planCurrent->amount / 100);
           
            // We check if the plan changed price

            if ($pricePlanOnStripe != $plan->price) {
                // Delete old plan
                $stripe->plans->delete($userPlan, []);

                // Delete Product
                $stripe->products->delete($planCurrent->product, []);
                // We create the plan with new price
                $this->createPlan($payment->key_secret, $plan, $user);
            }

        } catch (\Exception $exception) {
            // Create New Plan
            $this->createPlan($payment->key_secret, $plan, $user);
        }
     

      
        try {
            
            // Check Payment Incomplete
            if (auth()->user()
                ->userSubscriptions()
                ->where('stripe_price', $userPlan)
                ->whereStripeStatus('incomplete')
                ->first()
            ) {
                \Session::flash('error_message', __('general.please_confirm_payment'));
                return redirect()->route('creator.sub.plans');
            }

           
            // Create New subscription
            $metadata = [
                'interval' => $plan->interval,
                'taxes' => auth()->user()->taxesPayable(),
            ];

            $datt = auth()->user()->newSubscription('main', $userPlan)
                ->withMetadata($metadata)
                ->create();
            $datt->interval=$plan->interval;    
            $datt->is_admin=1;
            $datt->update();    
            // Activate old posts
            //Updates::where('user_id', $user->id)->update(['status'=>'active']);
            // Add Commission
            $user->custom_fee=$plan->commission;
            $user->update();
            // Insert Transaction
            $datatranac=$this->transaction(
                'subadmincreator_'.str_random(25),
                auth()->id(),
                0,//$subscription->id
                0,// $creator->id
                $plan->price,
                0,
                $plan->price,
                'Stripe',
                'admin_creator_subscription',
                $plan->commission.'%',
                auth()->user()->taxesPayable(),
            );
            $datatranac->is_admin=1;
            $datatranac->admin_pack_name=$plan->name;
            $datatranac->update();

            

            // Send Email to User and Notification
            //Subscriptions::sendEmailAndNotify(auth()->user()->name, $user->id);

             \Session::flash('message', __('general.subscription_success'));
             session()->put('subscription_success', trans('general.subscription_success'));
            //dd(\Session::get('subscription_success'));
            return redirect()->route('creator.sub.plans');
           
        } catch (IncompletePayment $exception) {

            // Insert ID Last Payment
            $subscriptions = Subscriptions::whereUserId(auth()->id())
                ->whereStripePrice($userPlan)
                ->whereStripeStatus('incomplete')
                ->first();

            $subscriptions->last_payment = $exception->payment->id;
            $subscriptions->save();

            $url = url('stripe/payment', $exception->payment->id);
            return redirect()->to($url);
        } catch (\Exception $exception) {
            \Log::debug($exception);

            \Session::flash('error_message', 'Unable to process request.Error:' . $exception->getMessage());
            return redirect()->route('creator.sub.plans');

        }
    } // End Method

    private function createPlan($keySecret, $plan, $user)
    {
        $stripe = new \Stripe\StripeClient($keySecret);

        switch ($plan->interval) {
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

        // If it does not exist we create the plan
        $stripe->plans->create([
            'currency' => $this->settings->currency_code,
            'interval' => $interval,
            'interval_count' => $interval_count,
            "product" => [
                "name" => trans('general.subscription_for').' '.$plan->name . ' @' . $user->username,
            ],
            'nickname' => $plan->name,
            'id' => $plan->name,
            'amount' => $this->settings->currency_code == 'JPY' ? $plan->price : ($plan->price * 100),
        ]);
    }

    public function subscriptionFree($id)
    {   
        $adminplan = AdminPlan::findOrFail($id);
        // Verify subscription exists

        $subexists=auth()->user()->userSubscriptions()->where('is_admin',1)->first();

        if ($subexists) {
            $this->deleteprevious();
        }
        
        $user=Auth::user();
        // Insert DB
        $sql          = new Subscriptions();
        $sql->user_id = auth()->id();
        $sql->stripe_price = $adminplan->name;
        $sql->free = 'yes';
        $sql->is_admin = 1;
        $sql->save();
        
        //Updates::where('user_id', $user->id)->update(['status'=>'active']);
        $user->custom_fee=$adminplan->commission;
        $user->update();

        \Session::flash('message', __('general.success'));
        return redirect()->route('creator.sub.plans');
    } // End Method SubscriptionFree

    static function deleteprevious()
    {   
        $checkSubscription=auth()->user()->userSubscriptions()->where('is_admin',1)->first();

        if($checkSubscription->free=='no' && $checkSubscription->strip_id){
           $payment = PaymentGateways::whereName('Stripe')->whereEnabled(1)->firstOrFail();
           $stripe = new \Stripe\StripeClient($payment->key_secret);
           try {
             $response = $stripe->subscriptions->cancel($checkSubscription->id, []);
           } catch (\Exception $e) {

             \Session::flash('error_message', $e->getMessage());
             return back()->withErrorMessage($e->getMessage());
           }
        }
        $usr=Auth::user();
        $usr->custom_fee=0;
        $usr->update();
        $checkSubscription->delete();
    }
}
