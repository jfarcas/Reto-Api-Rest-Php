<?php

namespace App\Tests\Service;

use App\Exception\ServerError;
use App\Service\ChuckJokeParser;
use PHPUnit\Framework\TestCase;

class ChuckJokeParserTest extends TestCase
{
    /**
     * @throws ServerError
     */
    public function testChuckJokeParser()
    {
        $service = new ChuckJokeParser();
        $inputData = ['id' => 1, 'value' => 'test'];
        $expectedData = ['id' => 1, 'joke' => 'test', 'type' => 'chuck'];
        $parsedData = $service->parseJoke($inputData);
        $this->assertEquals($expectedData, $parsedData);
        $this->assertInstanceOf(ChuckJokeParser::class, $service);
    }
}
