<?php

namespace App\Services\Stripe;

use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;
use Stripe\Subscription as StripeSubscription;

class StripeApiService
{
    public function __construct()
    {
        Stripe::setApiKey(config('cashier.secret'));
    }

    /**
     * Stripeチェックアウトセッションを取得
     */
    public function retrieveCheckoutSession(string $sessionId)
    {
        return CheckoutSession::retrieve($sessionId);
    }

    /**
     * Stripeサブスクリプションを取得（アイテムを展開）
     */
    public function retrieveSubscriptionWithItems(string $subscriptionId)
    {
        return StripeSubscription::retrieve(
            $subscriptionId,
            ['expand' => ['items.data.plan']]
        );
    }
}
