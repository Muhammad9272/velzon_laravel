<?php

namespace App\Http\Controllers\Front;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Subscriptions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Http\Controllers\WebhookController;
use Stripe\PaymentIntent as StripePaymentIntent;
use Stripe\Subscription as StripeSubscription;
use Symfony\Component\HttpFoundation\Response;
class StripeWebHookController extends WebhookController
{
    
    public function handleCustomerSubscriptionCreated(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);
        if ($user) {
            $data = $payload['data']['object'];

            if (! $user->subscriptions->contains('stripe_id', $data['id'])) {
                if (isset($data['trial_end'])) {
                    $trialEndsAt = Carbon::createFromTimestamp($data['trial_end']);
                } else {
                    $trialEndsAt = null;
                }

                $firstItem = $data['items']['data'][0];
                $isSinglePrice = count($data['items']['data']) === 1;

                $subscription = $user->subscriptions()->create([
                    'name' => $data['metadata']['name'] ?? $this->newSubscriptionName($payload),
                    'stripe_id' => $data['id'],
                    'stripe_status' => $data['status'],
                    'stripe_price' => $isSinglePrice ? $firstItem['price']['id'] : null,
                    'quantity' => $isSinglePrice && isset($firstItem['quantity']) ? $firstItem['quantity'] : null,
                    'trial_ends_at' => $trialEndsAt,
                    'ends_at' => null,
                ]);

                foreach ($data['items']['data'] as $item) {
                    $subscription->items()->create([
                        'stripe_id' => $item['id'],
                        'stripe_product' => $item['price']['product'],
                        'stripe_price' => $item['price']['id'],
                        'quantity' => $item['quantity'] ?? null,
                    ]);
                }


            }
            //Create Transaction & update suscription timeperiod
                $gs=GeneralSetting::find(1);
                $object     = $payload['data']['object'];
                $amount=$payload['data']['object']['items']['data'][0]['plan']['amount'];
                $subscription = $user->subscriptions()->firstOrNew(['stripe_id' => $object['id']]);
                $amount   = $gs->currency_code == 'JPY' ? $amount : ($amount / 100);
                AppHelper::transaction(
                              $payload['id'],
                              $subscription?$subscription->user_id:'',
                              $subscription?$subscription->id:'',
                              $amount,
                              'Stripe', 'subscription',
                              $object['status'],
                 );
                $subscription->ends_at=Carbon::createFromTimestamp($data['current_period_end']);
                $subscription->update();
            //Create Transaction & update suscription timeperiod ends
            
        }
        return $this->successMethod();
    }

    public function handleCustomerSubscriptionUpdated(array $payload)
    {   
        if ($user = $this->getUserByStripeId($payload['data']['object']['customer'])) {
            $data = $payload['data']['object'];
            $user->trial_ends_at=Carbon::now();
            $user->update();

            $subscription = $user->subscriptions()->firstOrNew(['stripe_id' => $data['id']]);

            if (
                isset($data['status']) &&
                $data['status'] === StripeSubscription::STATUS_INCOMPLETE_EXPIRED
            ) {
                $subscription->items()->delete();
                $subscription->delete();

                return;
            }

            $subscription->name = $subscription->name ?? $data['metadata']['name'] ?? $this->newSubscriptionName($payload);

            $firstItem = $data['items']['data'][0];
            $isSinglePrice = count($data['items']['data']) === 1;

            // Price...
            $subscription->stripe_price = $isSinglePrice ? $firstItem['price']['id'] : null;

            // Quantity...
            $subscription->quantity = $isSinglePrice && isset($firstItem['quantity']) ? $firstItem['quantity'] : null;

            // Trial ending date...
            if (isset($data['trial_end'])) {
                $trialEnd = Carbon::createFromTimestamp($data['trial_end']);

                if (! $subscription->trial_ends_at || $subscription->trial_ends_at->ne($trialEnd)) {
                    $subscription->trial_ends_at = $trialEnd;
                }
            }

            // Cancellation date...
            if (isset($data['cancel_at_period_end'])) {
                if ($data['cancel_at_period_end']) {
                    $subscription->ends_at = $subscription->onTrial()
                        ? $subscription->trial_ends_at
                        : Carbon::createFromTimestamp($data['current_period_end']);
                } elseif (isset($data['cancel_at'])) {
                    $subscription->ends_at = Carbon::createFromTimestamp($data['cancel_at']);
                } else {
                    $subscription->ends_at = null;
                }
            }

            // Status...
            if (isset($data['status'])) {
                $subscription->stripe_status = $data['status'];
            }

            $subscription->save();


 

            // Update subscription items...
            if (isset($data['items'])) {
                $prices = [];

                foreach ($data['items']['data'] as $item) {
                    $prices[] = $item['price']['id'];

                    $subscription->items()->updateOrCreate([
                        'stripe_id' => $item['id'],
                    ], [
                        'stripe_product' => $item['price']['product'],
                        'stripe_price' => $item['price']['id'],
                        'quantity' => $item['quantity'] ?? null,
                    ]);
                }

                // Delete items that aren't attached to the subscription anymore...
                $subscription->items()->whereNotIn('stripe_price', $prices)->delete();
            }


            //Create Transaction & update suscription timeperiod
                $gs=GeneralSetting::find(1);
                $object     = $payload['data']['object'];
                $amount=$payload['data']['object']['items']['data'][0]['plan']['amount'];
                $subscription = $user->subscriptions()->firstOrNew(['stripe_id' => $object['id']]);
                $amount   = $gs->currency_code == 'JPY' ? $amount : ($amount / 100);
                AppHelper::transaction(
                              $payload['id'],
                              $subscription?$subscription->user_id:'',
                              $subscription?$subscription->id:'',
                              $amount,
                              'Stripe', 'subscription',
                              $object['status'],
                 );
                $subscription->ends_at=Carbon::createFromTimestamp($data['current_period_end']);
                $subscription->update();
            //Create Transaction & update suscription timeperiod ends
        }



        return $this->successMethod();
    }
}
