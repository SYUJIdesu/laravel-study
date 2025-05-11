<?php

namespace App\Services\Stripe;

use App\Services\Stripe\WebhookHandlers\SubscriptionDeletedHandler;
use App\Services\Stripe\WebhookHandlers\SubscriptionUpdatedHandler;
use App\Services\Stripe\WebhookHandlers\WebhookHandlerInterface;
use Illuminate\Contracts\Container\Container;

class WebhookHandlerFactory
{
    /**
     * コンテナインスタンス
     */
    protected Container $container;

    /**
     * 新しいファクトリインスタンスを作成
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * イベントタイプに基づいて適切なハンドラーを作成
     *
     * @param  string  $eventType  Stripeイベントタイプ
     */
    public function create(string $eventType): ?WebhookHandlerInterface
    {
        return match ($eventType) {
            'customer.subscription.updated' => $this->container->make(SubscriptionUpdatedHandler::class),
            'customer.subscription.deleted' => $this->container->make(SubscriptionDeletedHandler::class),
            default => null
        };
    }
}
