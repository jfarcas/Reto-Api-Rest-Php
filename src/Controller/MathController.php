<?php

namespace App\Controller;

use App\Entity\Joke;
use App\Exception\InvalidInputData;
use App\Serializer\ApiSerializer;
use App\Service\JokeProviderFactory;
use App\Service\MathService;
use App\Service\MathValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MathController extends AbstractController
{
    const INCREMENT_NUMBER = 1;

    /**
     * @throws InvalidInputData
     */
    public function getLeastCommonMultiple(Request $request, MathValidator $mathValidator, MathService $mathService): Response
    {
        $numbers = $request->get('numbers', '');

        $numbers = $mathValidator->validateNumbers($numbers);
        $data = [
            'numbers' => $numbers,
            'leastCommonMultiple' => $mathService->getLeastCommonMultiple($numbers)
        ];
        return new JsonResponse($data, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     * @throws InvalidInputData
     */
    public function getIncrementedNumber(Request $request, MathValidator $mathValidator, MathService $mathService): Response
    {
        $number = $request->get('number');
        $mathValidator->validateNumber($number);

        $data = [
            'number' => 1,
            'incrementedNumber' => $mathService->incrementNumber($number, self::INCREMENT_NUMBER)
        ];
        return new JsonResponse($data, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
