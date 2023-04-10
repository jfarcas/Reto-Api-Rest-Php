<?php

namespace App\Controller;

use App\Exception\LoggableException;
use App\Service\NoSqlLoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ErrorController extends AbstractController
{
    public function show(\Throwable $exception, ?DebugLoggerInterface $logger, NoSqlLoggerInterface $noSqlLog): JsonResponse
    {
        if ($exception instanceof LoggableException) {
            return new JsonResponse([
                'alias' => $exception->getAlias(),
                'message' => $exception->getMessage(),
                'type' => $exception->getType(),
                'code' => $exception->getStatusCode(),
                'params' => $exception->getParams(),
            ]);
        }

        $noSqlLog->log('internalServerError', $exception->getMessage(), 'ERROR', 500, []);
        return new JsonResponse([
            'alias' => 'internalServerError',
            'message' => $exception->getMessage(),
            'type' => 'ERROR',
            'code' => 500,
            'params' => [],
        ]);
    }
}
