<?php

declare(strict_types=1);

namespace Arthurpar06\LaravelDiscordNotifications\Messages\Embed;

class Thumbnail {
    protected(set) string $url;
    protected(set) ?string $proxy_url = null;
    protected(set) ?int $height = null;
    protected(set) ?int $width = null;

    public static function create(): self
    {
        return new self();
    }
    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }
    public function proxy_url(?string $proxy_url): self
    {
        $this->proxy_url = $proxy_url;
        return $this;
    }
    public function height(?int $height): self
    {
        $this->height = $height;
        return $this;
    }
    public function width(?int $width): self
    {
        $this->width = $width;
        return $this;
    }
    public function toArray(): array
    {
        return array_filter([
            'url' => $this->url,
            'proxy_url' => $this->proxy_url,
            'height' => $this->height,
            'width' => $this->width,
        ]);
    }
}