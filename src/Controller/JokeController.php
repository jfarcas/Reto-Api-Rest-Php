<?php

namespace App\Controller;

use App\Entity\Joke;
use App\Exception\InvalidInputData;
use App\Serializer\ApiSerializer;
use App\Service\JokeProviderFactory;
use App\Service\RandomTypeGenerator;
use App\Validator\JsonValidator;
use App\Validator\StringValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class JokeController extends AbstractController
{
    /**
     * @throws InvalidInputData
     */
    public function getJokesByType(string $type, JokeProviderFactory $jokeProviderFactory): Response
    {
        $jokeProvider = $jokeProviderFactory->create($type);
        $randomJoke = $jokeProvider->getRandomJoke();
        return new JsonResponse($randomJoke, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     * @throws InvalidInputData
     */
    public function getRandomJoke(JokeProviderFactory $jokeProviderFactory, RandomTypeGenerator $randomTypeGenerator): Response
    {
        $randomType = $randomTypeGenerator->generateRandomType();
        $jokeProvider = $jokeProviderFactory->create($randomType);
        $randomJoke = $jokeProvider->getRandomJoke();
        return new JsonResponse($randomJoke, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    public function getJokes(JokeService $jokeService): Response
    {
        $jokes = $jokeService->getJokes();
        $jokesData = [];
        /** @var Joke $joke */
        foreach ($jokes as $joke) {
            $jokesData[] = [
                'number' => $joke->getNumber(),
                'joke' => $joke->getJoke(),
                'type' => $joke->getType(),
            ];
        }
        return new JsonResponse($jokesData, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     * @throws InvalidInputData
     * @throws \Exception
     */
    public function createJoke(
        Request $request,
        StringValidator $stringValidator,
        JsonValidator $jsonValidator,
        ApiSerializer $serializer,
        JokeService $jokeService,
        ValidatorInterface $validator
    ): Response {
        $content = $request->getContent();
        if (!$stringValidator->validate($content) || !$jsonValidator->validate($content)) {
            throw new InvalidInputData('invalidInputData', 'Invalid input data. Must be a valid Json string', 'Error', 400, []);
        }

        $joke = $serializer->deserialize($content, Joke::class, 'json');
        $violationList = $validator->validate($joke);
        if (count($violationList) > 0) {
            $params = [];
            foreach ($violationList as $violation) {
                $params[] = [
                    'property' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                ];
            }
            throw new InvalidInputData('invalidInputData', 'Invalid input data. ', 'Error', Response::HTTP_BAD_REQUEST, $params);
        }

        $joke = $jokeService->saveJoke($joke);
        $responseData = $serializer->serialize($joke, 'json');
        return new Response($responseData, Response::HTTP_CREATED, ['Content-Type' => 'application/json']);
    }

    /**
     * @throws InvalidInputData
     * @throws \Exception
     */
    public function updateJoke(
        Request $request,
        string $number,
        StringValidator $stringValidator,
        JsonValidator $jsonValidator,
        ApiSerializer $serializer,
        JokeService $jokeService,
        ValidatorInterface $validator
    ): Response {
        $content = $request->getContent();
        if (!$stringValidator->validate($content) || !$jsonValidator->validate($content)) {
            throw new InvalidInputData('invalidInputData', 'Invalid input data. Must be a valid Json string', 'Error', 400, []);
        }
        $joke = $jokeService->getJoke($number);
        $arrContent = json_decode($content, true);
        foreach ($arrContent as $field => $value) {
            $setter = 'set' . ucfirst($field);
            if (method_exists($joke, $setter)) {
                $joke->$setter($value);
            }
        }
        $violationList = $validator->validate($joke);
        if (count($violationList) > 0) {
            $params = [];
            foreach ($violationList as $violation) {
                $params[] = [
                    'property' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                ];
            }
            throw new InvalidInputData('invalidInputData', 'Invalid input data. ', 'Error', 400, $params);
        }

        $joke = $jokeService->saveJoke($joke);
        $responseData = $serializer->serialize($joke, 'json');
        return new Response($responseData, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     * @throws \Exception
     */
    public function deleteJoke(string $number, JokeService $jokeService): Response
    {
        $joke = $jokeService->getJoke($number);
        $jokeService->deleteJoke($joke);
        return new Response(null, Response::HTTP_NO_CONTENT, ['Content-Type' => 'application/json']);
    }
}
