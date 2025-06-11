<?php

namespace Arthurpar06\LaravelDiscordNotifications;

/**
 * Polyfill to check if mbstring is installed.
 *
 * @param string $str
 *
 * @return int
 *
 * @since 5.0.12
 */
function poly_strlen(string $str): int
{
    return function_exists('mb_strlen')
        ? mb_strlen($str)
        : strlen($str);
}

    /**
     * Resolves a color to an integer.
     *
     * @param array|int|string $color
     *
     * @throws \InvalidArgumentException `$color` cannot be resolved
     *
     * @return int
     */
function parse_color(mixed $color): ?int
    {
        if (is_null($color)) {
            return null;
        }

        if (is_string($color)) {
            $color = ltrim($color, '#');
            if (strlen($color) === 6) {
                return hexdec($color);
            }
            throw new \InvalidArgumentException('Color must be a valid hex color code.');
        }

        if (is_int($color) || is_int($color)) {
            return (int) $color;
        }

        throw new \InvalidArgumentException('Color must be a string or an integer.');
    }


    /**
     * Ensures a URL is valid for use in embeds.
     *
     * @param ?string $url
     * @param array $allowed Allowed URL scheme
     *
     * @throws \DomainException
     *
     * @return void
     */
    function ensure_valid_url(?string $url = null, array $allowed = ['http', 'https', 'attachment']): void
    {
        if (null !== $url && ! in_array(parse_url($url, PHP_URL_SCHEME), $allowed)) {
            throw new \DomainException('URL scheme only supports '.implode(', ', $allowed));
        }
    }