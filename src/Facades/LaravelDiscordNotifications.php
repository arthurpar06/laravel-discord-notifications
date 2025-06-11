<?php

namespace Arthurpar06\LaravelDiscordNotifications\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Arthurpar06\LaravelDiscordNotifications\LaravelDiscordNotifications
 */
class LaravelDiscordNotifications extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Arthurpar06\LaravelDiscordNotifications\LaravelDiscordNotifications::class;
    }
}
