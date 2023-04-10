<?php

namespace App\Service;

use App\Exception\InvalidInputData;
use GuzzleHttp\Client;

class JokeProviderFactory
{

    protected string $dadJokeApiUrl;
    protected string $chuckJokeApiUrl;
    protected Client $client;
    public function __construct(string $dadJokeApiUrl, string $chuckJokeApiUrl, Client $client)
    {
        $this->dadJokeApiUrl = $dadJokeApiUrl;
        $this->chuckJokeApiUrl = $chuckJokeApiUrl;
        $this->client = $client;
    }

    /**
     * @throws InvalidInputData
     */
    public function create(string $type): JokeProviderInterface
    {
        switch ($type) {
            case 'chuck':
                return new ChuckJokeProvider($this->chuckJokeApiUrl, $this->client);
            case 'dad':
                return new DadJokeProvider($this->dadJokeApiUrl, $this->client);
            default:
                throw new InvalidInputData('invalidInputData', 'Invalid input data. Type is not allowed. Only "dad" and "chuck" types are allowed', 'Error', 400, []);
        }
    }
}
