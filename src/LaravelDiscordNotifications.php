<?php

namespace Arthurpar06\LaravelDiscordNotifications;

use Arthurpar06\LaravelDiscordNotifications\Exceptions\CouldNotSendNotification;
use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Arr;

class LaravelDiscordNotifications
{
    /**
     * Discord API base URL.
     */
    protected string $baseUrl = 'https://discord.com/api';

    /**
     * API HTTP client.
     */
    protected HttpClient $httpClient;

    /**
     * Discord API token.
     */
    protected string $token;

    public function __construct(HttpClient $http, string $token)
    {
        $this->httpClient = $http;
        $this->token = $token;
    }

    /**
     * Send a message to a Discord channel.
     *
     * @param  string  $channel
     * @return array
     */
    public function send($channel, array $data)
    {
        return $this->request('POST', 'channels/'.$channel.'/messages', $data);
    }

    /**
     * Get a private channel with another Discord user from their snowflake ID.
     *
     * @param  string  $userId
     * @return string
     */
    public function getPrivateChannel($userId)
    {
        return $this->request('POST', 'users/@me/channels', ['recipient_id' => $userId])['id'];
    }

    /**
     * Perform an HTTP request with the Discord API.
     *
     *
     *
     * @throws CouldNotSendNotification
     */
    protected function request(string $verb, string $endpoint, array $data): array
    {
        $url = rtrim($this->baseUrl, '/').'/'.ltrim($endpoint, '/');

        try {
            $response = $this->httpClient->request($verb, $url, [
                'headers' => [
                    'Authorization' => 'Bot '.$this->token,
                ],
                'json' => $data,
            ]);
        } catch (RequestException $exception) {
            if ($response = $exception->getResponse()) {
                throw CouldNotSendNotification::serviceRespondedWithAnHttpError($response, $response->getStatusCode(), $exception);
            }

            throw CouldNotSendNotification::serviceCommunicationError($exception);
        } catch (Exception $exception) {
            throw CouldNotSendNotification::serviceCommunicationError($exception);
        }

        $body = json_decode($response->getBody(), true);

        if (Arr::get($body, 'code', 0) > 0) {
            throw CouldNotSendNotification::serviceRespondedWithAnApiError($body, $body['code']);
        }

        return $body;
    }
}
