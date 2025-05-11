<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class SubscriptionData extends Data
{
    public function __construct(
        #[TypeScriptOptional]
        public readonly string $stripeId,
        public readonly string $type,
        public readonly string $stripeStatus,
        public readonly string $stripePrice,
        public readonly int $quantity,
        public readonly ?Carbon $trialEndsAt,
        public readonly ?Carbon $endsAt,
        public readonly array $items
    ) {}

    // DTOをモデル更新用の配列に変換
    public function toSubscriptionArray(): array
    {
        return [
            'type' => $this->type,
            'stripe_status' => $this->stripeStatus,
            'stripe_price' => $this->stripePrice,
            'quantity' => $this->quantity,
            'trial_ends_at' => $this->trialEndsAt,
            'ends_at' => $this->endsAt,
        ];
    }
}
