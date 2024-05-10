<?php

namespace App\Services;

use GuzzleHttp\Client;

class RemoveBgService
{
    protected $client;
    protected $apiToken;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.ximilar.com/',
            'timeout'  => 25.0,
        ]);

        $this->apiToken = env('XIMILAR_API_TOKEN'); // Ваш API токен здесь
    }

    public function removeBackground($imageUrl)
    {
        $response = $this->client->post('removebg/precise/removebg', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Token ' . $this->apiToken,
            ],
            'json' => [
                'records' => [
                    [
                        '_url' => $imageUrl,
                        'binary_mask' => false,
                        'white_background' => false,
                    ],
                ],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}


