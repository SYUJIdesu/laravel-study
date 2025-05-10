<?php

namespace App\Services\Stripe\WebhookHandlers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

// チェックアウトセッションの完了
class CheckoutSessionCompletedHandler implements WebhookHandlerInterface
{
    public function handle($session): void
    {
        $user = User::where('email', $session->customer_email)->first();
        if (! $user) {
            Log::warning('User not found for checkout.session.completed', ['email' => $session->customer_email]);

            return;
        }

        $user->update(['stripe_id' => $session->customer]);

        $user->subscriptions()->updateOrCreate(
            ['stripe_id' => $session->subscription],
            [
                'name' => 'default',
                'stripe_status' => 'active',
                'stripe_price' => null, // 後で更新
                'quantity' => 1,
                'trial_ends_at' => null,
                'ends_at' => null,
            ]
        );

        Log::info('Subscription created from checkout', ['user_id' => $user->id]);
    }
}
