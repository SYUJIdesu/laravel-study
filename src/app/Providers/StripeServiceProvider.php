<?php

namespace App\Providers;

use App\Services\Stripe\WebhookHandlerFactory;
use Illuminate\Support\ServiceProvider;

class StripeServiceProvider extends ServiceProvider
{
    /**
     * すべてのアプリケーションサービスを登録
     */
    public function register(): void
    {
        $this->app->singleton(WebhookHandlerFactory::class, function ($app) {
            return new WebhookHandlerFactory($app);
        });
    }
}
