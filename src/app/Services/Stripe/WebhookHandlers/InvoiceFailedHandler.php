<?php

namespace App\Services\Stripe\WebhookHandlers;

use Illuminate\Support\Facades\Log;

// 請求書の支払い失敗
class InvoiceFailedHandler implements WebhookHandlerInterface
{
    public function handle($invoice): void
    {
        Log::warning('Invoice payment failed', ['invoice_id' => $invoice->id, 'customer' => $invoice->customer]);
        // 例：支払い失敗通知、猶予期間処理など
    }
}
