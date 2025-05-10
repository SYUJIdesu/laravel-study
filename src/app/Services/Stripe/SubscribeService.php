<?php

namespace App\Services\Stripe;

use App\Models\User;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;

class SubscribeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('cashier.secret'));
    }

    public function createCheckoutSession(string $priceId, User $user): string
    {

        // セッションパラメータを準備
        $customer = $user->createOrGetStripeCustomer();
        $sessionParams = [
            'customer' => $customer->id,
            'customer_update' => ['address' => 'auto'],
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [[
                'price' => $priceId,
                'quantity' => 1,
            ]],
            'payment_method_options' => [
                'card' => [ // 3Dセキュア
                    'request_three_d_secure' => 'any',
                ],
            ],
            'success_url' => route('subscribe.comp', [], true).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => url()->previous(),
        ];

        $session = CheckoutSession::create($sessionParams);

        return $session->url;
    }
}
