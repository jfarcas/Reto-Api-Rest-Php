<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JokeTest extends WebTestCase
{
    public function testGetJokeByType(): void
    {

        $client = static::createClient();

        $client->request('GET', '/api/v1/jokes-by-type/dad');
        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true );
        $this->assertArrayHasKey('id', $responseData);
        $this->assertArrayHasKey('joke', $responseData);
        $this->assertArrayHasKey('type', $responseData);

        $client->request('GET', '/api/v1/jokes-by-type/chuck');
        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true );
        $this->assertArrayHasKey('id', $responseData);
        $this->assertArrayHasKey('joke', $responseData);
        $this->assertArrayHasKey('type', $responseData);

        $client->request('GET', '/api/v1/jokes/random');
        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true );
        $this->assertArrayHasKey('id', $responseData);
        $this->assertArrayHasKey('joke', $responseData);
        $this->assertArrayHasKey('type', $responseData);

        $client->request('GET', '/api/v1/jokes-by-type/invalid');
        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true );
        $this->assertArrayHasKey('alias', $responseData);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('code', $responseData);
        $this->assertArrayHasKey('params', $responseData);

    }

    public function testGetJokes(): void
    {

        $client = static::createClient();

        $client->request('GET', '/api/v1/jokes');
        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true );
        $expected = json_decode(file_get_contents(__DIR__ . '/fixtures/jokes.json'), true );
        $this->assertEquals($expected, $responseData);
    }

    /** @depends testGetJokes */
    public function testCrudJoke(): void
    {
        $client = static::createClient();

        $postData = [
            'joke' => 'test joke with more than 10 characters',
            'type' => 'dad',
            'number' => 3
        ];

        $client->request('POST', '/api/v1/jokes', [], [], [], json_encode($postData));
        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true );
        $this->assertEquals($postData, $responseData);

        $putData = [
            'joke' => 'test joke with more than 10 characters changed',
            'type' => 'dad',
            'number' => 3
        ];

        $client->request('PUT', '/api/v1/jokes/3', [], [], [], json_encode($putData));
        $response = $client->getResponse();
        $responseData = json_decode($response->getContent(), true );
        $this->assertEquals($putData, $responseData);

        $client->request('DELETE', '/api/v1/jokes/3');
        $response = $client->getResponse();
        $responseCode = $response->getStatusCode();
        $this->assertEquals(204, $responseCode);
    }
}

