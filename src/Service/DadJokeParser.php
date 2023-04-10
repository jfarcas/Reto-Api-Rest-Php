<?php

namespace App\Service;

use App\Exception\ServerError;

class DadJokeParser implements JokeParserInterface
{
    /**
     * @throws ServerError
     */
    public function parseJoke(array $joke): array
    {
        if (!isset($joke['id'])  || !isset($joke['joke'])) {
            throw new ServerError('serverError', 'Server error', 'Error', 500, []);
        }
        return [
            'id' => $joke['id'],
            'joke' => $joke['joke'],
            'type' => 'dad'
        ];
    }
}
