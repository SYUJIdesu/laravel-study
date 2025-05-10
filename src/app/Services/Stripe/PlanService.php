<?php

namespace App\Services\Stripe;

use App\Repositories\StripePlanRepository;

class PlanService
{
    public function __construct(
        protected StripePlanRepository $repository
    ) {}

    public function getPlans(): array
    {
        return $this->repository->getActivePlans();
    }
}
