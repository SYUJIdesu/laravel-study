<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\Optional as TypeScriptOptional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class PlanWithPlansData extends Data
{
    public function __construct(
        #[TypeScriptOptional]
        public string $plan_id,
        public string $name,
        public ?string $description,
        /** @var PlanData[] */
        public array $plans,
    ) {}
}
