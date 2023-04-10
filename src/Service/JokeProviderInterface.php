<?php

namespace App\Service;

interface JokeProviderInterface
{
    public function getRandomJoke(): array;
}
