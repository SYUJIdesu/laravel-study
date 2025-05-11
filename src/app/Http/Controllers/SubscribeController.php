<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeCheckoutRequest;
use App\Services\Stripe\SubscribeService;
use App\Services\Stripe\SubscriptionCompletionService;
use App\Services\Stripe\WebhookHandlerFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Stripe\Webhook;

class SubscribeController extends Controller
{
    public function __construct(
        private WebhookHandlerFactory $webhookHandlerFactory,
        private SubscriptionCompletionService $subscriptionCompletionService
    ) {}

    // サブスクリプションのチェックアウト
    public function checkout(SubscribeCheckoutRequest $request, SubscribeService $subscribeService)
    {
        $user = $request->user();
        $sessionUrl = $subscribeService->createCheckoutSession($request->price_id, $user);

        return Inertia::location($sessionUrl);
    }

    // サブスクリプションの完了
    public function comp(Request $request)
    {
        $sessionId = $request->query('session_id');
        if (! $sessionId) {
            abort(403, 'Checkout session ID is required.');
        }

        try {
            // サービスクラスに処理を委譲
            $this->subscriptionCompletionService->completeSubscription(
                $sessionId,
                $request->user()
            );

            return Inertia::render('Subscribes/Comp');
        } catch (\Exception $e) {
            Log::error('Subscription completion error:', ['error' => $e->getMessage()]);
        }
    }

    // サブスクリプションの顧客ポータル
    public function customerPortal(Request $request, SubscribeService $subscribeService)
    {
        $url = $subscribeService->createCustomerPortalUrl($request->user());

        return Inertia::location($url);
    }

    // サブスクリプションのWebhook
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('cashier.webhook.secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);

            // ★ ココで event->data->object をログ出力
            Log::info('Stripe Webhook payload data.object:', [
                'object' => $event->data->object,
            ]);
            Log::info('$event->type):', [
                'object' => $event->type,
            ]);

            // ファクトリーを使用して適切なハンドラーを取得
            $handler = $this->webhookHandlerFactory->create($event->type);

            if (! $handler) {
                throw new \Exception('Webhook handler not found');
            }

            // イベントデータをハンドラーに渡す
            $handler->handle($event->data->object);

            return response('Webhook handled', 200);
        } catch (\Exception $e) {
            Log::error('Stripe Webhook error:', ['error' => $e->getMessage()]);

            return response('Invalid payload', 400);
        }
    }
}
