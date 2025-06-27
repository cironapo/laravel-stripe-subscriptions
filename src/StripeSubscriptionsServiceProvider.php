<?php

namespace Cironapo\StripeSubscriptions;

use Illuminate\Support\ServiceProvider;

class StripeSubscriptionsServiceProvider extends ServiceProvider
{
    public function register()
    {
        //$this->mergeConfigFrom(__DIR__.'/../config/subscriptions.php', 'subscriptions');
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../config/subscriptions.php' => config_path('subscriptions.php'),
        ], 'subscriptions-config');

        $this->publishes([
            __DIR__.'/../resources/js/Pages' => resource_path('js/Pages/Subscriptions'),
        ], 'subscriptions-inertia-pages');
    }
}
