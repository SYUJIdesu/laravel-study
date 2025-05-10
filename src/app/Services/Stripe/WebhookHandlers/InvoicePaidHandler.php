<?php

namespace App\Services\Stripe\WebhookHandlers;

use Illuminate\Support\Facades\Log;

// 請求書の支払い
class InvoicePaidHandler implements WebhookHandlerInterface
{
    public function handle($invoice): void
    {
        Log::info('Invoice paid', ['invoice_id' => $invoice->id, 'customer' => $invoice->customer]);
        // 例：請求履歴保存や支払い完了通知を送る
    }
}
