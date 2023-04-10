<?php

namespace App\Service;

interface JokeParserInterface
{
    public function parseJoke(array $joke): array;
}
