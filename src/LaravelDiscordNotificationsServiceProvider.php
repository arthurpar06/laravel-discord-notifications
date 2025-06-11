<?php

namespace Arthurpar06\LaravelDiscordNotifications;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Arthurpar06\LaravelDiscordNotifications\Commands\LaravelDiscordNotificationsCommand;

class LaravelDiscordNotificationsServiceProvider extends PackageServiceProvider
{
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
