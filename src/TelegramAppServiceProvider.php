<?php

namespace Promoxp\Telegram;

use Illuminate\Support\ServiceProvider;

class TelegramAppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot()
    {
        // Publish configuration file
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . '/../config/notification-telegram.php' => config_path('notification-telegram.php'),
                ],
                'notification-telegram-config',
            );
        }
    }

    public function register()
    {
        // Merge package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/notification-telegram.php', 'notification-telegram');
    }
}
