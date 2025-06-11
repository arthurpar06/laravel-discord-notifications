<?php

namespace Arthurpar06\LaravelDiscordNotifications\Commands;

use Illuminate\Console\Command;

class LaravelDiscordNotificationsCommand extends Command
{
    public $signature = 'laravel-discord-notifications';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
