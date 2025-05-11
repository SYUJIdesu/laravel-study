<?php

namespace App\Repositories;

use App\Models\SubscriptionItem;
use Illuminate\Database\Eloquent\Model;

class SubscriptionItemRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(SubscriptionItem::class);
    }

    /**
     * サブスクリプションアイテムをStripe IDで更新または作成
     */
    public function updateOrCreateByStripeId(
        int $subscriptionId,
        string $stripeId,
        array $attributes
    ): Model {
        $itemData = array_merge(['subscription_id' => $subscriptionId], $attributes);

        return $this->model->updateOrCreate(
            ['stripe_id' => $stripeId],
            $itemData
        );
    }
}
