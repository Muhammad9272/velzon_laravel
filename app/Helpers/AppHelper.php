<?php
namespace App\Helpers;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\User;
use Auth;
use Session;
use Carbon\Carbon;
class AppHelper
{

    public static function setCurrency($price) {
        $gs = GeneralSetting::findOrFail(1);
        $price = number_format($price,2);
        if($gs->currency_format == 1){
            return '$'.$price;
        }
        else{
            return $price.'$';
        }
    }
    public static function getPrice($price) {
        return $price=number_format($price,2);
    }
    public static function setInterval($interval) {
       return ucfirst($interval);
    }
    


    


        // Insert Transaction
    public static function transaction(
        $txnId,
        $userId,
        $subscriptionsId,
        $amount,
        $paymentGateway,
        $type,
        $status,
        // $percentageApplied,
        // $taxes,
        $approved = '1'
        ) {
                    $earning_net_user=0;
                    $earning_net_admin=($status=='active')?$amount:0;
                    $referred_by='';

                    $gs=GeneralSetting::find(1);
                    $user=User::find($userId);
                    if($gs->is_affilate==1 && $user->referred_by){
                        if($status=='active'){
                            $earning_net_user=$gs->user_comission;
                            $earning_net_admin=($amount-$gs->user_comission);
                        }                        
                        $referred_by=$user->referred_by;
                    }


                    // Insert Transaction
                    $txn = new Transaction();
                    $txn->txn_id  = $txnId;
                    $txn->user_id = $userId;
                    $txn->subscriptions_id = $subscriptionsId;
                    // $txn->subscribed = ;
                    $txn->amount   = $amount;

                    $txn->earning_net_user  = $earning_net_user;
                    $txn->earning_net_admin = $earning_net_admin;
                    $txn->referrer_link=$referred_by;

                    $txn->payment_gateway = $paymentGateway;
                    $txn->type = $type;
                    $txn->status = $status;
                    // $txn->percentage_applied = $percentageApplied;
                    $txn->approved = $approved;
                    // $txn->referred_commission = $referred ? true : false;
                    // $txn->taxes = $taxes;
                    // $txn->direct_payment = $stripeConnect ?? false;
                    $txn->save();

                    // Update Transaction ID on ReferralTransactions
                    return $txn;

        }// End Method Insert Transaction


}