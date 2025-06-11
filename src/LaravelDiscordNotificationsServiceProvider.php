<?php

namespace Arthurpar06\LaravelDiscordNotifications;

use Arthurpar06\LaravelDiscordNotifications\Commands\LaravelDiscordNotificationsCommand;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelDiscordNotificationsServiceProvider extends PackageServiceProvider
{
    public function register(): void
    {
        parent::register();

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('discord', function ($app) {
                return new Channels\DiscordChannel;
            });
        });
    }

    public function boot(): void
    {
        parent::boot();

        $token = $this->app->make('config')->get('services.discord.token');

        $this->app->when(LaravelDiscordNotifications::class)
            ->needs('$token')
            ->give($token);
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-discord-notifications')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_discord_notifications_table')
            ->hasCommand(LaravelDiscordNotificationsCommand::class);
    }
}
