<?php

namespace Arthurpar06\LaravelDiscordNotifications\Messages;

use function Arthurpar06\LaravelDiscordNotifications\poly_strlen;

class DiscordMessage {
    /**
     * Content of the message.
     *
     * @var string|null
     */
    protected ?string $content;

    /**
     * Whether the message is text-to-speech.
     *
     * @var bool
     */
    protected bool $tts = false;

    /**
     * Array of embeds to send with the message.
     *
     * @var array[]|null
     */
    protected ?array $embeds;

    /**
     * Allowed mentions object for the message.
     *
     * @var AllowedMentions|array|null
     */
    protected $allowed_mentions;

    /**
     * Message to reply to with this message.
     *
     * @var Message|null
     */
    protected $replyTo;

    /**
     * Message to forward with this message.
     *
     * @var Message|null
     */
    protected $forward;

    /**
     * Components to send with this message.
     *
     * @var ComponentObject[]|null
     */
    protected ?array $components;

    /**
     * IDs of up to 3 stickers in the server to send in the message.
     *
     * @var string[]
     */
    protected array $sticker_ids = [];

    /**
     * Files to send with this message.
     *
     * @var array[]|null
     */
    protected ?array $files;

    /**
     * Attachments to send with this message.
     *
     * @var Attachment[]|null
     */
    protected ?array $attachments;

    /**
     * The poll for the message.
     *
     * @var Poll|null
     */
    protected $poll;

    /**
     * Flags to send with this message.
     *
     * @var int|null
     */
    protected ?int $flags;

    /**
     * Whether to enforce the nonce.
     *
     * @var bool|null
     */
    protected ?bool $enforce_nonce;

    public static function create(): self {
        return new self();
    }


    /**
     * Sets the content of the message.
     *
     * @param string $content Content of the message. Maximum 2000 characters.
     *
     * @throws \LengthException
     *
     * @return $this
     */
    public function content(string $content): self {
        if (poly_strlen($content) > 2000) {
            throw new \LengthException('Message content must be less than or equal to 2000 characters.');
        }

        $this->content = $content;
        return $this;
    }
 
    /**
     * Sets the TTS status of the message. Only used for sending message or executing webhook.
     *
     * @param bool $tts
     *
     * @return $this
     */
    public function setTts(bool $tts = false): self
    {
        $this->tts = $tts;

        return $this;
    }

    /**
     * Adds an embed to the builder.
     *
     * @param Embed|array ...$embeds
     *
     * @throws \OverflowException Builder exceeds 10 embeds.
     *
     * @return $this
     */
    public function embed(...$embeds): self
    {
        foreach ($embeds as $embed) {
            if ($embed instanceof Embed) {
                $embed = $embed->getRawAttributes();
            }

            if (isset($this->embeds) && count($this->embeds) >= 10) {
                throw new \OverflowException('You can only have 10 embeds per message.');
            }

            $this->embeds[] = $embed;
        }

        return $this;
    }

    
    /**
     * Sets the embeds for the message. Clears the existing embeds in the process.
     *
     * @param Embed[]|array ...$embeds
     *
     * @return $this
     */
    public function setEmbeds(array $embeds): self
    {
        $this->embeds = [];

        return $this->embed(...$embeds);
    }
}