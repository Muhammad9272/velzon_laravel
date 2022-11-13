<?php

namespace App\Models;

use App\Helpers\AppHelper;
use App\Models\GeneralSetting;
use App\Models\Subscriptions;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Auth;
class User extends Authenticatable
{ 
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'affiliate_code',
        'phone',
        'role_id',
        'referred_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userSubscriptions()
    {
      return $this->hasMany(Subscriptions::class);
    }

    public function subscriptionsActive()
    {
            $activeplan=$this->userSubscriptions()->where('stripe_id', '!=', '')->orderBy('id','desc')->first();
            $now = Carbon::now()->subMinutes(2);
            if($activeplan && $activeplan->stripe_status=="active"){
                  return $this->userSubscriptions()
                  ->where('stripe_id', '!=', '')
                  ->where('ends_at', '>=', $now)
                  ->where('stripe_status','active')
                  ->orderBy('id','desc')
                  ->first();
            }elseif($activeplan && $activeplan->stripe_status=="trialing" ){
                  return $this->userSubscriptions()
                  ->where('stripe_id', '!=', '')
                  ->where('trial_ends_at', '>=', $now)
                  ->where('stripe_status','trialing') 
                  ->orderBy('id','desc')
                  ->first();
            }else{
               return;
            }// return $this->userSubscriptions()         
            //   ->where('stripe_id', '!=', '')
            //     ->where('ends_at', '>=', now())
            //     ->whereIn('stripe_status',['active', 'trialing']) 
            // ->first();
    }

    public function freetrial($value='')
    {
        if(auth()->user()->userSubscriptions()->exists()){
            return false;
        }else{
            return true;
        }
    }
    //****************User Transaction & Balance Modules****************//
    protected  function activeTransaction() {
        $gs=GeneralSetting::find(1);
        $user=Auth::user();
        $datenow=Carbon::now()->subDays($gs->withdrawl_after_days);

        return $earning_net_user=Transaction::where('referrer_link',$user->affiliate_code)
               ->where('status','active')
               ->where('created_at','<=',$datenow)
               ->where('is_cleared',0); //2<=-25
               // ->where('is_cleared',0)
               // ->sum('earning_net_user');
    }
    public  function userbalance($withCurrency='') {

        $activeTransaction=$this->activeTransaction();
        $earning_net_user=0;
        if($activeTransaction){
            $earning_net_user=$activeTransaction->sum('earning_net_user');
        }

        if($withCurrency && $withCurrency==1){
          return AppHelper::setCurrency($earning_net_user);
        }else{
            return $earning_net_user;
        }                      
    }
    public function userbalancedecrement($value='')
    {  
        $activeTransaction=$this->activeTransaction();
        if($activeTransaction){
            $activeTransaction->update(['is_cleared'=>1]);
        }
    }
    //****************User Transaction & Balance Modules****************//

}
