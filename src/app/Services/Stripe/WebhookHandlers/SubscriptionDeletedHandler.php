<?php

namespace App\Services\Stripe\WebhookHandlers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

// サブスクのキャンセル
class SubscriptionDeletedHandler implements WebhookHandlerInterface
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
                'stripe_status' => 'canceled',
                'ends_at' => now(),
            ]);

        Log::info('Subscription canceled', ['user_id' => $user->id]);
    }
}
