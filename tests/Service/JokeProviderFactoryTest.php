<?php

namespace App\Tests\Service;

use App\Exception\InvalidInputData;
use App\Service\ChuckJokeProvider;
use App\Service\DadJokeProvider;
use App\Service\JokeProviderFactory;
use GuzzleHttp\Client;
use GuzzleHttp\ClientTrait;
use PHPUnit\Framework\TestCase;

class JokeProviderFactoryTest extends TestCase
{
    /**
     * @throws InvalidInputData
     */
    public function testJokeProviderFactory()
    {
        $mock = $this->createMock(Client::class);
        $service = new JokeProviderFactory(
            '',
            '',
            $mock,

        );

        $dadJokeProvider = $service->create('dad');
        $chuckJokeProvider = $service->create('chuck');
        $this->assertInstanceOf(JokeProviderFactory::class, $service);
        $this->assertInstanceOf(DadJokeProvider::class, $dadJokeProvider);
        $this->assertInstanceOf(ChuckJokeProvider::class, $chuckJokeProvider);

        try {
            $service->create('test');
        } catch (InvalidInputData $e) {
            $this->assertInstanceOf(InvalidInputData::class, $e);
        }
    }
}
