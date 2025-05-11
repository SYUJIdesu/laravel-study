<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class SubscriptionItemData extends Data
{
    public function __construct(
        #[TypeScriptOptional]
        public readonly string $stripeId,
        public readonly string $stripeProduct,
        public readonly string $stripePrice,
        public readonly int $quantity
    ) {}

    // DTOをモデル更新用の配列に変換
    public function toArray(): array
    {
        return [
            'stripe_id' => $this->stripeId,
            'stripe_product' => $this->stripeProduct,
            'stripe_price' => $this->stripePrice,
            'quantity' => $this->quantity,
        ];
    }
}
