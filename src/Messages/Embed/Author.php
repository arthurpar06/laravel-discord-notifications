<?php

declare(strict_types=1);

namespace Arthurpar06\LaravelDiscordNotifications\Messages\Embed;

use function Arthurpar06\LaravelDiscordNotifications\poly_strlen;

class Author {
    protected(set) string $name;
    protected(set) ?string $url = null;
    protected(set) ?string $icon_url = null;
    protected(set) ?string $proxy_icon_url = null;

    public static function create(): self
    {
        return new self();
    }

    public function name(string $name): self
    {
        if (poly_strlen($name) === 0) {
            throw new \InvalidArgumentException('Author name cannot be empty.');
        } elseif (poly_strlen($name) > 256) {
            throw new \InvalidArgumentException('Author name cannot be longer than 256 characters.');
        }
        $this->name = $name;
        return $this;
    }

    public function url(string $url): self
    {
        $this->url = $url;
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
            'name' => $this->name,
            'url' => $this->url,
            'icon_url' => $this->icon_url,
            'proxy_icon_url' => $this->proxy_icon_url,
        ]);
    }
}