<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class PlanData extends Data
{
    public function __construct(
        #[TypeScriptOptional]
        public string $price_id,
        public int $unit_amount,
        public string $currency,
        public ?string $interval,
    ) {}
}
