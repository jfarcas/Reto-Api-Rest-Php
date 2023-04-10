<?php

namespace App\Exception;

abstract class AbstractException extends \Exception implements LoggableException
{
    private string $alias;
    private string $type;
    private array $params;

    public function __construct(string $alias, string $message, string $type, int $code, array $params = [])
    {
        parent::__construct($message, $code);
        $this->alias = $alias;
        $this->type = $type;
        $this->params = $params;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function getType(): string
    {
        return $this->type;
    }
    public function getParams(): array
    {
        return $this->params;
    }
    public function getStatusCode(): int
    {
        return $this->getCode();
    }
}
