<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id()->comment('主キー');
            $table->foreignId('user_id')->comment('契約しているユーザーID（usersテーブルへの外部キー）');
            $table->string('type')->comment('サブスクリプション名（通常は default）');
            $table->string('stripe_id')->unique()->comment('Stripe 上のサブスクリプションID（例: sub_XXXX）');
            $table->string('stripe_status')->comment('Stripe 上のステータス（例: active、canceled、incomplete など）');
            $table->string('stripe_price')->nullable()->comment('Stripe 上の価格ID（例: price_XXXX）');
            $table->integer('quantity')->nullable()->comment('契約数（通常1）');
            $table->timestamp('trial_ends_at')->nullable()->comment('トライアル終了日時（ある場合）');
            $table->timestamp('ends_at')->nullable()->comment('サブスクリプションの終了日時（キャンセル済みの場合）');
            $table->timestamps();
            $table->index(['user_id', 'stripe_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
