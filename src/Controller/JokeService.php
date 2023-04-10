<?php

namespace App\Controller;

use App\Entity\Joke;
use App\Exception\ItemNotFound;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class JokeService
{
    protected EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws \Exception
     */
    public function saveJoke(Joke $joke): Joke
    {
        try {
            $this->entityManager->persist($joke);
            $this->entityManager->flush();
            return $joke;
        } catch (\Exception $exception) {
//            todo throw custom exception
            throw new \Exception('Error saving joke');
        }
    }

    /**
     * @throws ItemNotFound
     */
    public function getJoke(string $number):Joke
    {
        $repo = $this->entityManager->getRepository(Joke::class);
        $joke = $repo->find($number);
        if (!$joke instanceof Joke) {
            throw new ItemNotFound('itemNotFound', 'Joke not found', 'Error', Response::HTTP_NOT_FOUND, ['id' => $number]);
        }
        return $joke;
    }

    public function deleteJoke(Joke $joke):void
    {
        $this->entityManager->remove($joke);
        $this->entityManager->flush();
    }

    public function getJokes():array
    {
        $repo = $this->entityManager->getRepository(Joke::class);
        return  $repo->findAll();
    }
}
