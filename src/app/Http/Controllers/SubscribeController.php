<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeCheckoutRequest;
use App\Services\Stripe\SubscribeService;
use App\Services\Stripe\WebhookHandlerFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Stripe\Webhook;

class SubscribeController extends Controller
{
    public function checkout(SubscribeCheckoutRequest $request, SubscribeService $subscribeService)
    {
        $user = $request->user();
        $sessionUrl = $subscribeService->createCheckoutSession($request->price_id, $user);

        return Inertia::location($sessionUrl);
    }

    public function comp()
    {
        return Inertia::render('Subscribes/Comp');
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Exception $e) {
            return response('Invalid payload', 400);
        }

        // ファクトリーを使用して適切なハンドラーを取得
        $handler = WebhookHandlerFactory::create($event->type);

        if ($handler) {
            // ハンドラーが存在する場合は処理を委譲
            $handler->handle($event->data->object);
        } else {
            // 未処理のイベントタイプをログに記録
            Log::info('Unhandled webhook event: '.$event->type);
        }

        return response('Webhook handled', 200);
    }
}
