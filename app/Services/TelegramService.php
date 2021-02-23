<?php

namespace App\Services;

use App\Models\User;
use GuzzleHttp\Client;

class TelegramService
{
    private $apiKey;
    private $client;
    private $channelId;

    public function __construct(array $config)
    {
        $this->apiKey = $config['apiKey'];
        $this->channelId = (int)$config['channelId'];
        $this->client = new Client();
    }

    public function sendMessage(string $text)
    {
        if (is_null($this->channelId)) {
            \Log::warning('Telegram message not sent because channel id is not set');
            return;
        }

        if (is_null($this->apiKey)) {
            \Log::warning('Telegram message not sent because API key is not set');
            return;
        }

        $this->client->post('https://api.telegram.org/bot' . $this->apiKey . '/sendMessage', [
            'json' => [
                'chat_id' => $this->channelId,
                'text' => $text,
            ],
        ]);
    }
}
