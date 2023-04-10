<?php

namespace App\Exception;

interface LoggableException
{
    public function getAlias(): string;
    public function getMessage();
    public function getType(): string;
    public function getStatusCode(): int;
    public function getParams(): array;
}
