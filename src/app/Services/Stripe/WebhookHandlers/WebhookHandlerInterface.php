<?php

namespace App\Services\Stripe\WebhookHandlers;

interface WebhookHandlerInterface
{
    /**
     * Webhook イベントを処理する
     *
     * @param  $payload  イベントデータ
     */
    public function handle($payload): void;
}
