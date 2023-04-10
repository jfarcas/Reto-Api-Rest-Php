<?php

namespace App\Service;

use App\Exception\ServerError;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class DadJokeProvider implements JokeProviderInterface
{
    protected string $apiJokeUrl;
    protected Client $client;

    public function __construct($apiJokeUrl, Client $client)
    {
        $this->apiJokeUrl = $apiJokeUrl;
        $this->client = $client;
    }

    /**
     * @throws ServerError
     */
    public function getRandomJoke(): array
    {
        $parser = new DadJokeParser();

        try {
            $response = $this->client->get($this->apiJokeUrl, [
                'timeout' => 5,
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]);
            $data = json_decode($response->getBody()->getContents(), true);
            return $parser->parseJoke($data);
        } catch (\Exception|GuzzleException $exception) {
            throw new ServerError('serverError', 'Server error', 'Error', 500, []);
        }
    }
}
