<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ChuckJokeProvider implements JokeProviderInterface
{
    protected string $apiJokeUrl;
    protected Client $client;
    public function __construct($apiJokeUrl, Client $client)
    {
        $this->apiJokeUrl = $apiJokeUrl;
        $this->client = $client;
    }
    public function getRandomJoke(): array
    {
        $parser = new ChuckJokeParser();
        $client = new Client([
            'timeout'  => 5.0,
        ]);
        $data = [];
        try {
            $response = $client->get($this->apiJokeUrl . '/jokes/random');
            $data = json_decode($response->getBody()->getContents(), true);
        } catch (\Exception|GuzzleException $exception) {
//            todo si hay excepcione devolvemos un 500 por ser un error de servidor y el cliente no puede hacer nada para corregir la respuesta
        }
        return $parser->parseJoke($data);
    }
}
