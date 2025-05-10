<?php

namespace App\Services\Stripe\WebhookHandlers;

use App\Models\User;
use Carbon\Carbon;

// サブスクの更新
class SubscriptionUpdatedHandler implements WebhookHandlerInterface
{
    public function handle($subscription): void
    {
        $user = User::where('stripe_id', $subscription->customer)->first();
        if (! $user) {
            return;
        }

        $user->subscriptions()
            ->where('stripe_id', $subscription->id)
            ->update([
                'stripe_status' => $subscription->status,
                'stripe_price' => $subscription->items->data[0]->price->id ?? null,
                'trial_ends_at' => isset($subscription->trial_end)
                    ? Carbon::createFromTimestamp($subscription->trial_end)
                    : null,
                'ends_at' => $subscription->cancel_at ? Carbon::createFromTimestamp($subscription->cancel_at) : null,
            ]);
    }
}
