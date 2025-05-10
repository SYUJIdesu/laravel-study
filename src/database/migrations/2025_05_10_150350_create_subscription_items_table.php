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
        Schema::create('subscription_items', function (Blueprint $table) {
            $table->id()->comment('主キー');
            $table->foreignId('subscription_id')->comment('紐づく subscriptions テーブルのID');
            $table->string('stripe_id')->unique()->comment('Stripe 上のサブスクリプションアイテムID（例: si_XXXX）');
            $table->string('stripe_product')->comment('Stripe 上のプロダクトID（例: prod_XXXX）');
            $table->string('stripe_price')->comment('Stripe 上の価格ID（例: price_XXXX）');
            $table->integer('quantity')->nullable()->comment('契約数（例: ライセンス数など、通常は1）');
            $table->timestamps();
            $table->index(['subscription_id', 'stripe_price']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_items');
    }
};
