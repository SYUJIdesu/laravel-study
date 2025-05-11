<?php

namespace App\Services\Stripe;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;
use Stripe\StripeClient;

class SubscribeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('cashier.secret'));
    }

    /**
     * チェックアウトセッションを作成する
     */
    public function createCheckoutSession(string $priceId, User $user): string
    {

        return DB::transaction(function () use ($priceId, $user) {
            // セッションパラメータを準備
            Stripe::setApiKey(config('cashier.secret'));
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
        });
    }

    /**
     * 顧客ポータルの URL を生成して返す
     */
    public function createCustomerPortalUrl(User $user): string
    {
        // StripeClient インスタンスを生成
        $stripe = new StripeClient(config('cashier.secret'));

        // カスタマーポータルセッションを作成
        $session = $stripe->billingPortal->sessions->create([
            'customer' => $user->stripe_id,
            'return_url' => route('home'),
        ]);

        return $session->url;
    }
}
