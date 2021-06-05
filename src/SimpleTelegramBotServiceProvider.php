<?php

namespace Plasticground\SimpleTelegramBot;

use Illuminate\Support\ServiceProvider;

class SimpleTelegramBotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/simple-telegram-bot.php', 'simple-telegram-bot'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->publishes([
            __DIR__ . '/config/simple-telegram-bot.php' => config_path('simple-telegram-bot.php'),
        ]);
    }
}
