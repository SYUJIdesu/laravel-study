<?php

namespace App\Http\Controllers;

use App\Services\Stripe\PlanService;
use Inertia\Inertia;

class PlanController extends Controller
{
    public function __construct(
        protected PlanService $service
    ) {}

    public function index()
    {
        $plans = $this->service->getPlans();

        return Inertia::render('Plans/Index', [
            'plans' => $plans,
        ]);
    }
}
