<?php

declare(strict_types=1);

namespace Arthurpar06\LaravelDiscordNotifications\Messages\Embed;

class Footer {
    protected(set) string $text;
    protected(set) ?string $icon_url = null;
    protected(set) ?string $proxy_icon_url = null;

    public static function create(): self
    {
        return new self();
    }

    public function text(string $text): self
    {
        if (mb_strlen($text) === 0) {
            throw new \InvalidArgumentException('Footer text cannot be empty.');
        } elseif (mb_strlen($text) > 2048) {
            throw new \InvalidArgumentException('Footer text cannot be longer than 2048 characters.');
        }
        
        $this->text = $text;
        return $this;
    }

    public function icon_url(string $icon_url): self
    {
        $this->icon_url = $icon_url;
        return $this;
    }

    public function proxy_icon_url(string $proxy_icon_url): self
    {
        $this->proxy_icon_url = $proxy_icon_url;
        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'text' => $this->text,
            'icon_url' => $this->icon_url,
            'proxy_icon_url' => $this->proxy_icon_url,
        ]);
    }
}