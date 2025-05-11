<?php

namespace App\Repositories;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class SubscriptionRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(Subscription::class);
    }

    /**
     * サブスクリプションをStripe IDで更新または作成
     */
    public function updateOrCreateByStripeId(User $user, string $stripeId, array $attributes): Model
    {
        return $user->subscriptions()->updateOrCreate(
            ['stripe_id' => $stripeId],
            $attributes
        );
    }
}
