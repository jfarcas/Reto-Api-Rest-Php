<?php

namespace App\Service;

use App\Exception\ServerError;

class ChuckJokeParser implements JokeParserInterface
{
    /**
     * @throws ServerError
     */
    public function parseJoke(array $joke): array
    {
        if (!isset($joke['id'])  || !isset($joke['value'])) {
            throw new ServerError('serverError', 'Server error', 'Error', 500, []);
        }
        return [
            'id' => $joke['id'],
            'joke' => $joke['value'],
            'type' => 'chuck'
        ];
    }
}
