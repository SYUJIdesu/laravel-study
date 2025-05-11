<?php

namespace App\Repositories;

use App\Models\User;

// ユーザー
class UserRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(User::class);
    }

    /**
     * メールアドレスでユーザーを検索する
     */
    public function findByEmail(string $email): ?User
    {
        /** @var \App\Models\User|null */
        return $this->model->where('email', $email)->first();
    }

    /**
     * StripeIDを更新する
     *
     * @return bool 更新に成功した場合はtrue、失敗した場合はfalse
     */
    public function updateStripeId(int $userId, string $stripeId): bool
    {
        // update()はboolを返すのでそのまま返す
        return (bool) $this->model->where('id', $userId)->update(['stripe_id' => $stripeId]);
    }
}
