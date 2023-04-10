<?php

namespace App\Tests\Service;

use App\Exception\ServerError;
use App\Service\ChuckJokeParser;
use App\Service\DadJokeParser;
use PHPUnit\Framework\TestCase;

class DadJokeParserTest extends TestCase
{
    /**
     * @throws ServerError
     */
    public function testChuckJokeParser()
    {
        $service = new DadJokeParser();
        $inputData = ['id' => 1, 'joke' => 'test'];
        $expectedData = ['id' => 1, 'joke' => 'test', 'type' => 'dad'];
        $parsedData = $service->parseJoke($inputData);
        $this->assertEquals($expectedData, $parsedData);
        $this->assertInstanceOf(DadJokeParser::class, $service);
    }
}
