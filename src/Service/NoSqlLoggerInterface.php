<?php

namespace App\Service;

interface NoSqlLoggerInterface
{
    public function log(string $alias, string $message, string $type, int $code, array $params): void;
}
