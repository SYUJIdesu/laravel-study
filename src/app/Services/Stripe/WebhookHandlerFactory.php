<?php

namespace App\Services\Stripe;

use App\Services\Stripe\WebhookHandlers\CheckoutSessionCompletedHandler;
use App\Services\Stripe\WebhookHandlers\InvoiceFailedHandler;
use App\Services\Stripe\WebhookHandlers\InvoicePaidHandler;
use App\Services\Stripe\WebhookHandlers\SubscriptionDeletedHandler;
use App\Services\Stripe\WebhookHandlers\SubscriptionUpdatedHandler;
use App\Services\Stripe\WebhookHandlers\WebhookHandlerInterface;

class WebhookHandlerFactory
{
    /**
     * イベントタイプに基づいて適切なハンドラーを作成
     *
     * @param  string  $eventType  Stripeイベントタイプ
     */
    public static function create(string $eventType): ?WebhookHandlerInterface
    {
        return match ($eventType) {
            'checkout.session.completed' => new CheckoutSessionCompletedHandler,
            'invoice.paid' => new InvoicePaidHandler,
            'invoice.payment_failed' => new InvoiceFailedHandler,
            'customer.subscription.updated' => new SubscriptionUpdatedHandler,
            'customer.subscription.deleted' => new SubscriptionDeletedHandler,
            default => null
        };
    }
}
