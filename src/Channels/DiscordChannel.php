<?php

namespace Arthurpar06\LaravelDiscordNotifications\Channels;

use Arthurpar06\LaravelDiscordNotifications\Exceptions\CouldNotSendNotification;
use Arthurpar06\LaravelDiscordNotifications\Facades\LaravelDiscordNotifications;
use Illuminate\Notifications\Notification;

class DiscordChannel
{
    public function __construct(
        protected LaravelDiscordNotifications $discord
    ) {}

    /**
     * Send the given notification.
     *
     *
     *
     * @throws CouldNotSendNotification
     */
    public function send(mixed $notifiable, Notification $notification): array
    {
        if (! $channel = $notifiable->routeNotificationFor('discord', $notification)) {
            return;
        }

        $message = $notification->toDiscord($notifiable);

        $data = [
            'content' => $message->body,
        ];

        if (count($message->embed) > 0) {
            $data['embeds'] = [$message->embed];
        }

        if (count($message->components) > 0) {
            $data['components'] = $message->components;
        }

        return $this->discord->send($channel, $data);
    }
}
