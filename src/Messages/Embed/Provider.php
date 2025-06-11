<?php

declare(strict_types=1);

namespace Arthurpar06\LaravelDiscordNotifications\Messages\Embed;

class Provider {
    protected(set) ?string $name = null;
    protected(set) ?string $url = null;

    public static function create(): self
    {
        return new self();
    }

    public function name(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function url(?string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'url' => $this->url,
        ]);
    }
}