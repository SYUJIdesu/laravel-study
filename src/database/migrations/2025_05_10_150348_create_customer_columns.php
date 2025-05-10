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
        Schema::table('users', function (Blueprint $table) {
            $table->string('stripe_id')->nullable()->index()
                ->comment('Stripe 上の顧客ID（例: cus_XXXX）')->after('remember_token');

            $table->string('pm_type')->nullable()
                ->comment('登録された支払い方法の種類（例: card）')->after('stripe_id');

            $table->string('pm_last_four', 4)->nullable()
                ->comment('支払い方法（クレジットカードなど）の下4桁')->after('pm_type');

            $table->timestamp('trial_ends_at')->nullable()
                ->comment('全体的な無料トライアル終了日時（サブスクではなくユーザー単位）')->after('pm_last_four');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex([
                'stripe_id',
            ]);

            $table->dropColumn([
                'stripe_id',
                'pm_type',
                'pm_last_four',
                'trial_ends_at',
            ]);
        });
    }
};
