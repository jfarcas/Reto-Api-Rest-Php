<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Joke;

class JokeFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $joke = new Joke();
         $joke->setJoke('Chuck Norris can divide by zero.');
         $joke->setType('custom');
         $joke->setNumber(1);

         $manager->persist($joke);

        $joke = new Joke();
        $joke->setJoke('Chuck Norris can write infinite recursion functions and have them return.');
        $joke->setType('custom');
        $joke->setNumber(1);
        $manager->persist($joke);

         $manager->flush();
    }
}
