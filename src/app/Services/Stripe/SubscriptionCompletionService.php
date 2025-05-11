<?php

namespace App\Services\Stripe;

use App\Data\SubscriptionData;
use App\Data\SubscriptionItemData;
use App\Models\User;
use App\Repositories\SubscriptionItemRepository;
use App\Repositories\SubscriptionRepository;
use App\Values\DateValue;
use Illuminate\Support\Facades\DB;

class SubscriptionCompletionService
{
    public function __construct(
        private StripeApiService $stripeApiService,
        private SubscriptionRepository $subscriptionRepository,
        private SubscriptionItemRepository $subscriptionItemRepository
    ) {}

    /**
     * サブスクリプション完了処理を実行
     */
    public function completeSubscription($sessionId, User $user): void
    {

        // トランザクションで全てのDB操作をラップ
        DB::transaction(function () use ($sessionId, $user) {
            // Stripeからセッションを取得
            $checkoutSession = $this->stripeApiService->retrieveCheckoutSession($sessionId);

            // Stripeからサブスクリプション詳細を取得
            $stripeSubscription = $this->stripeApiService->retrieveSubscriptionWithItems($checkoutSession->subscription);

            // DTOを作成
            $subscriptionDTO = $this->createSubscriptionDTO($stripeSubscription);

            // サブスクリプションを保存/更新
            $subscription = $this->subscriptionRepository->updateOrCreateByStripeId(
                $user,
                $subscriptionDTO->stripeId,
                $subscriptionDTO->toSubscriptionArray()
            );

            // サブスクリプションアイテムを保存
            foreach ($subscriptionDTO->items as $itemDTO) {
                $this->subscriptionItemRepository->updateOrCreateByStripeId(
                    $subscription->getKey(),
                    $itemDTO->stripeId,
                    $itemDTO->toArray()
                );
            }

            // 通知を送信
            $user->notify(new \App\Notifications\SubscriptionCompleted);
        });
    }

    /**
     * StripeサブスクリプションデータからDTO作成
     */
    private function createSubscriptionDTO($stripeSub): SubscriptionData
    {
        $items = [];
        foreach ($stripeSub->items->data as $item) {
            $items[] = new SubscriptionItemData(
                $item->id,
                $item->plan->product,
                $item->plan->id,
                $item->quantity
            );
        }

        return new SubscriptionData(
            $stripeSub->id,
            $stripeSub->items->data[0]->plan->nickname ?? $stripeSub->items->data[0]->plan->id,
            $stripeSub->status,
            $stripeSub->items->data[0]->plan->id,
            $stripeSub->items->data[0]->quantity,
            $stripeSub->trial_end ? DateValue::getCarbonFromTimestamp($stripeSub->trial_end) : null,
            $stripeSub->cancel_at ? DateValue::getCarbonFromTimestamp($stripeSub->cancel_at) : null,
            $items
        );
    }
}
