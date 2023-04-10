<?php

namespace App\Core\ApiClient;

interface ApiClient
{
    public function get(string $url): array;
}
