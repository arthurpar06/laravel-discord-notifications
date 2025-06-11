<?php

declare(strict_types=1);

namespace Arthurpar06\LaravelDiscordNotifications\Messages\Embed;

use Carbon\Carbon;

use function Arthurpar06\LaravelDiscordNotifications\parse_color;
use function Arthurpar06\LaravelDiscordNotifications\poly_strlen;

class Embed {
    protected(set) ?string $title = null;
    protected(set) ?string $description = null;
    protected(set) ?string $url = null;
    protected(set) ?string $timestamp = null;
    protected(set) ?int $color = null;
    protected(set) ?Footer $footer = null;
    protected(set) ?Image $image = null;
    protected(set) ?Thumbnail $thumbnail = null;
    protected(set) ?Video $video = null;
    protected(set) ?Provider $provider = null;
    protected(set) ?Author $author = null;
    protected(set) array $fields = [];

    public function field(...$fields): self 
    {
        foreach ($fields as $field) {
            if (count($this->fields) >= 25) {
                throw new \OverflowException('Embeds can not have more than 25 fields.');
            }

            if (! $field instanceof Field) {
                throw new \InvalidArgumentException('Fields must be instances of Arthurpar06\LaravelDiscordNotifications\Messages\Embed\Field');
            }

            $this->fields[] = $field;
        }

        return $this;
    }

    public function fields(array $fields): self
    {
        $this->fields = [];
        $this->field(...$fields);

        return $this;
    }

    public function color(mixed $color): self
    {
        $this->color = parse_color($color);

        return $this;
    }

    public function description(string $description): self
    {
        if (poly_strlen($description) == 0) {
            $this->description = null;
        } elseif (poly_strlen($description) > 4096) {
            throw new \LengthException('Description must be less than 4096 characters.');
        } elseif ($this->exceedsOverallLimit(poly_strlen($description))) {
            throw new \LengthException('Embed text values collectively can not exceed than 6000 characters');
        } else {
            $this->description = $description;
        }

        return $this;
    }

    public function title(string $title): self
    {
        if (poly_strlen($title) == 0) {
            $this->title = null;
        } elseif (poly_strlen($title) > 256) {
            throw new \LengthException('Title must be less than 256 characters.');
        } elseif ($this->exceedsOverallLimit(poly_strlen($title))) {
            throw new \LengthException('Embed text values collectively can not exceed than 6000 characters');
        } else {
            $this->title = $title;
        }

        return $this;
    }

    public function author(Author $author): self
    {
        if ($this->exceedsOverallLimit(poly_strlen($author->name))) {
            throw new \LengthException('Embed text values collectively can not exceed than 6000 characters');
        }

        $this->author = $author;

        return $this;
    }

    public function footer(Footer $footer): self
    {
        if (poly_strlen($footer->text) == 0) {
            $this->footer = null;
        } elseif (poly_strlen($footer->text) > 2048) {
            throw new \LengthException('Footer text must be less than 2048 characters.');
        } elseif ($this->exceedsOverallLimit(poly_strlen($footer->text))) {
            throw new \LengthException('Embed text values collectively can not exceed than 6000 characters');
        }

        $this->footer = $footer;

        return $this;
    }

    public function image(Image $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function thumbnail(Thumbnail $thumbnail): self
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    public function timestamp(Carbon|int $timestamp): self
    {
        if ($timestamp instanceof Carbon) {
            $this->timestamp = $timestamp->toIso8601String();
        } else {
            $this->timestamp = Carbon::createFromTimestamp($timestamp)->toIso8601String();
        }

        return $this;
    }

    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function video(Video $video): self
    {
        $this->video = $video;
        return $this;
    }

    public function provider(Provider $provider): self
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * Checks to see if adding a property has put us over Discord's 6000
     * characters overall limit.
     *
     * @param int $addition
     *
     * @return bool
     */
    protected function exceedsOverallLimit(int $addition): bool
    {
        $total = (
            poly_strlen(($this->title ?? '')) +
            poly_strlen(($this->description ?? '')) +
            poly_strlen(($this->footer?->text ?? '')) +
            poly_strlen(($this->author?->name ?? '')) +
            $addition
        );

        foreach ($this->fields as $field) {
            $total += poly_strlen($field->name);
            $total += poly_strlen($field->value);
        }

        return ($total > 6000);
    }


    public function toArray(): array
    {
        $embed = [
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'timestamp' => $this->timestamp,
            'color' => $this->color,
            'footer' => $this->footer?->toArray(),
            'image' => $this->image?->toArray(),
            'thumbnail' => $this->thumbnail?->toArray(),
            'video' => $this->video?->toArray(),
            'provider' => $this->provider?->toArray(),
            'author' => $this->author?->toArray(),
            'fields' => array_map(fn($field) => $field->toArray(), $this->fields),
        ];

        return array_filter($embed);
    }

}