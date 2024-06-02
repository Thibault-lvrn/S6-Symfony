<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GotenbergClient
{
    private $client;
    private $gotenbergUrl;

    public function __construct(HttpClientInterface $client, string $gotenbergUrl)
    {
        $this->client = $client;
        $this->gotenbergUrl = $gotenbergUrl;
    }

    public function convertUrlToPdf(string $url): string
    {
        $response = $this->client->request('POST', $this->gotenbergUrl, [
            'headers' => [
                'Content-Type' => 'multipart/form-data',
            ],
            'body' => [
                'url' => $url,
            ],
        ]);

        return $response->getContent();
    }
}
