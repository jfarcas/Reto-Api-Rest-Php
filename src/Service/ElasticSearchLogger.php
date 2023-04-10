<?php

namespace App\Service;

class ElasticSearchLogger implements NoSqlLoggerInterface
{
    public function log(string $alias, string $message, string $type, int $code, array $params): void
    {
        // TODO: Implement log() method.
    }
}
