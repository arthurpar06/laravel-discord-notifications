<?php

declare(strict_types=1);

namespace Arthurpar06\LaravelDiscordNotifications\Messages\Embed;

use function Arthurpar06\LaravelDiscordNotifications\poly_strlen;

class Field {
    protected(set) string $name;
    protected(set) string $value;
    protected(set) bool $inline = false;

    public static function create(): self
    {
        return new self();
    }

    public function name(string $name): self
    {
        if (poly_strlen($name) === 0) {
            throw new \InvalidArgumentException('Field name cannot be empty.');
        } elseif (poly_strlen($name) > 256) {
            throw new \InvalidArgumentException('Field name cannot be longer than 256 characters.');
        }

        $this->name = $name;
        return $this;
    }

    public function value(string $value): self
    {
        if (poly_strlen($value) === 0) {
            throw new \InvalidArgumentException('Field value cannot be empty.');
        } elseif (poly_strlen($value) > 1024) {
            throw new \InvalidArgumentException('Field value cannot be longer than 1024 characters.');
        }
        
        $this->value = $value;
        return $this;
    }

    public function inline(bool $inline): self
    {
        $this->inline = $inline;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
            'inline' => $this->inline,
        ];
    }
}