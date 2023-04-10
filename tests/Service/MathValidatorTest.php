<?php

namespace App\Tests\Service;

use App\Exception\InvalidInputData;
use App\Exception\LoggableException;
use App\Service\MathValidator;
use PHPUnit\Framework\TestCase;

class MathValidatorTest extends TestCase
{
    /**
     * @throws InvalidInputData
     */
    public function testValidateNumbers()
    {
        $validator = new MathValidator();
        $this->assertEquals([1, 2, 3], $validator->validateNumbers('1,2,3'));
    }

    /**
     * @throws InvalidInputData
     */
    public function testValidateNumbersAndThrowException()
    {
        $validator = new MathValidator();
        $expectedMessage = 'Invalid input data';
        $expectedCode = 400;
        $expectedAlias = 'invalidInputData';
        $expectedParams = [
            [
                'message' => 'Number must be integer',
                'number' => 'a'
            ]
        ];
        $exception = null;

        try {
            // Call the code that should throw the exception
            $validator->validateNumbers('1,2,a');
        } catch (InvalidInputData $e) {
            $exception = $e;
        }

        $this->assertInstanceOf(InvalidInputData::class, $exception);
        $this->assertEquals($expectedMessage, $exception->getMessage());
        $this->assertEquals($expectedCode, $exception->getStatusCode());
        $this->assertEquals($expectedAlias, $exception->getAlias());
        $this->assertEquals($expectedParams, $exception->getParams());
    }

    public function testValidateNumber()
    {
        $isValid = true;
        $validator = new MathValidator();
        try {
            $validator->validateNumber(3);
        } catch (\Exception $e) {
            $isValid = false;
        }
        $this->assertTrue($isValid);
    }

    public function testValidateNumberAndThrowException()
    {
        $isValid = true;
        $validator = new MathValidator();
        try {
            $validator->validateNumber('a');
        } catch (LoggableException $e) {
            $isValid = false;
            $this->assertEquals('Invalid input data', $e->getMessage());
            $this->assertEquals([['number' => 'a', 'message' => 'Number must be integer']], $e->getParams());
        }
        $this->assertFalse($isValid);

    }
}
