<?php

namespace App\Tests\Service;

use App\Service\MathService;
use PHPUnit\Framework\TestCase;

class MathServiceTest extends TestCase
{
    public function testIncrement()
    {
        $service = new MathService();
        $this->assertEquals(3, $service->incrementNumber(1, 2));
        $this->assertEquals(0, $service->incrementNumber(-1, 1));
        $this->assertEquals(1, $service->incrementNumber(0, 1));
        $this->assertEquals(100, $service->incrementNumber(100, 0));
    }

    public function testLeastCommonMultipleNumbers()
    {
        $service = new MathService();
        $this->assertEquals(12, $service->getLeastCommonMultiple([3, 4]));
        $this->assertEquals(84, $service->getLeastCommonMultiple([1,2,3,4,7]));
        $this->assertEquals(900, $service->getLeastCommonMultiple([12, 15, 75, 9]));
        $this->assertEquals(720720, $service->getLeastCommonMultiple([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16]));
    }

}
